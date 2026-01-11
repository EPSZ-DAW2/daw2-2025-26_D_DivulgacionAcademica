<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Documento;
use app\models\Materia; 
use app\models\DocumentoComentario;
use app\models\DocumentoValoracion;
use yii\web\UploadedFile; 
use yii\helpers\ArrayHelper; // Para los desplegables

class MaterialesController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        
        // 1. CONSULTA BASE
        $queryBase = Documento::find()->joinWith(['materia', 'autor', 'institucion']);

        // A. TEXTO
        if ($q = $request->get('q')) {
            $queryBase->andWhere(['or',
                ['like', 'documento.titulo', $q],
                ['like', 'materia.nombre', $q],
                ['like', 'personal.nombre', $q],
                ['like', 'institucion.nombre', $q]
            ]);
        }

        // B. TIPO Y ACCESO
        $types = $request->get('type');
        $access = $request->get('access');
        $filtrosAcceso = [];
        
        if (!empty($types) && is_array($types)) {
            if (in_array('apuntes', $types)) $filtrosAcceso[] = 'publico';
            if (in_array('examenes', $types)) $filtrosAcceso[] = 'privado';
        }
        
        if (!empty($access) && is_array($access)) {
             $accessLimpios = array_filter($access); 
             if (!empty($accessLimpios)) {
                 $filtrosAcceso = array_merge($filtrosAcceso, $accessLimpios);
             }
        }
        
        if (!empty($filtrosAcceso)) {
            $queryBase->andWhere(['in', 'documento.tipo_acceso', array_unique($filtrosAcceso)]);
        }

        // C. CATEGORÍAS
        $queryFinal = clone $queryBase;
        $categorias = $request->get('category');
        
        if (!empty($categorias)) {
            if (!is_array($categorias)) $categorias = [$categorias];
            $categorias = array_filter($categorias);
            
            $idsFamilia = [];
            foreach ($categorias as $catInput) {
                if (empty($catInput)) continue;

                $materia = null;
                if (is_numeric($catInput)) {
                    $materia = Materia::findOne($catInput);
                } else {
                    $materia = Materia::findOne(['nombre' => $catInput]);
                }

                if ($materia) {
                    $idsFamilia[] = $materia->id;
                    $hijos = Materia::find()->select('id')->where(['parentId' => $materia->id])->column();
                    $idsFamilia = array_merge($idsFamilia, $hijos);
                }
            }
            
            if (!empty($idsFamilia)) {
                $queryFinal->andWhere(['in', 'documento.materiaId', array_unique($idsFamilia)]);
            }
        }

        // 2. CONTADORES
        $mainCategories = Materia::find()->where(['parentId' => null])->orderBy('nombre ASC')->all();
        $categoryCounts = [];

        foreach ($mainCategories as $cat) {
            $familiaIds = array_merge(
                [$cat->id], 
                Materia::find()->select('id')->where(['parentId' => $cat->id])->column()
            );
            $total = Documento::find()->where(['in', 'materiaId', $familiaIds])->count();
            $categoryCounts[$cat->id] = $total;
        }

        // 3. DATOS
        $dataProvider = new ActiveDataProvider([
            'query' => $queryFinal,
            'pagination' => ['pageSize' => 9],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'mainCategories' => $mainCategories,
            'categoryCounts' => $categoryCounts,
        ]);
    }
    
    // VER DETALLE Y PROCESAR COMENTARIOS
    public function actionView($id)
    {
        $model = Documento::findOne($id);
        if (!$model) throw new \yii\web\NotFoundHttpException('El documento no existe.');

        $nuevoComentario = new DocumentoComentario();
        
        // Solo se procesa el comentario si el usuario ha iniciado sesion
        if (!Yii::$app->user->isGuest && $nuevoComentario->load(Yii::$app->request->post())) {
            
            $nuevoComentario->documentoId = $model->id;
            $nuevoComentario->usuarioId = Yii::$app->user->id; // ID real del usuario
            $nuevoComentario->fecha = date('Y-m-d H:i:s');

            if ($nuevoComentario->save()) {
                Yii::$app->session->setFlash('success', '¡Comentario publicado con éxito!');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar el comentario.');
            }
        }

        return $this->render('view', [
            'model' => $model,
            'nuevoComentario' => $nuevoComentario,
        ]);
    }

    // ACCIÓN PARA GUARDAR VOTOS
    public function actionValorar($id, $puntuacion)
    {
        // Si no está logueado, se va al login
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión para valorar documentos.');
            return $this->redirect(['site/login']);
        }

        $userId = Yii::$app->user->id;

        $valoracion = DocumentoValoracion::findOne(['usuarioId' => $userId, 'documentoId' => $id]);
        
        if (!$valoracion) {
            $valoracion = new DocumentoValoracion();
            $valoracion->usuarioId = $userId;
            $valoracion->documentoId = $id;
        }

        $valoracion->puntuacion = (int)$puntuacion;
        $valoracion->fecha = date('Y-m-d H:i:s');
        
        if($valoracion->save()) {
            Yii::$app->session->setFlash('success', '¡Gracias por valorar el documento!');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    // ACCIÓN PARA SUBIR NUEVO DOCUMENTO
    public function actionSubir()
    {
        $model = new Documento();

        // Datos para los desplegables del formulario
        $materias = ArrayHelper::map(Materia::find()->orderBy('nombre')->all(), 'id', 'nombre');
        $instituciones = ArrayHelper::map(\app\models\Institucion::find()->orderBy('nombre')->all(), 'id', 'nombre');
        $autores = ArrayHelper::map(\app\models\Personal::find()->orderBy('nombre')->all(), 'id', function($p){ return $p->nombre . ' ' . $p->apellidos; });

        if ($request = Yii::$app->request->post()) {
            
            // 1. Cargar datos del formulario
            if ($model->load($request)) {
                
                // 2. Obtener la instancia del archivo subido
                $model->archivoFile = UploadedFile::getInstance($model, 'archivoFile');

                if ($model->archivoFile && $model->validate()) {
                    
                    // 3. Generar nombre único
                    // Evita problemas si dos personas suben el mismo archivo
                    $nombreUnico = preg_replace('/[^a-zA-Z0-9]+/', '_', strtolower($model->titulo)) . '_' . time() . '.' . $model->archivoFile->extension;
                    
                    // 4. Mover el archivo a la carpeta 'web/uploads'
                    $rutaGuardado = 'uploads/' . $nombreUnico;
                    
                    if($model->archivoFile->saveAs($rutaGuardado)) {
                        // 5. Guardar solo el nombre en la Base de Datos
                        $model->archivo_url = $nombreUnico;
                        
                        // Guardar el registro completo
                        if ($model->save(false)) { // false porque ya se valido antes
                            Yii::$app->session->setFlash('success', '¡Documento subido correctamente!');
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }
            }
        }

        return $this->render('subir', [
            'model' => $model,
            'materias' => $materias,
            'instituciones' => $instituciones,
            'autores' => $autores,
        ]);
    }
}