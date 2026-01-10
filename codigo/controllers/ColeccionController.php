<?php

namespace app\controllers;

use Yii;
use app\models\Coleccion;
use app\models\Documento;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Dompdf\Dompdf;
use Dompdf\Options;

class ColeccionController extends Controller
{
    /**
     * Comportamientos: Control de acceso y verbos permitidos.
     */
public function behaviors()
{
    return [
        'access' => [
            'class' => \yii\filters\AccessControl::class,
            'only' => [
                'create', 'update', 'delete', 'unirse', 'abandonar', 
                'agregar-material', 'guardar-material', 'quitar-material', 'usuarios'
            ],
            'rules' => [
                // 1. Regla para Administradores (usando matchCallback)
                [
                    'actions' => ['usuarios', 'delete'], // El admin también puede borrar
                    'allow' => true,
                    'matchCallback' => function ($rule, $action) {
                        return !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin';
                    }
                ],
                // 2. Regla general para usuarios autenticados
                [
                    'actions' => [
                        'create', 'unirse', 'update', 'abandonar',
                        'agregar-material', 'guardar-material', 'quitar-material'
                    ],
                    'allow' => true,
                    'roles' => ['@'], 
                ],
            ],
        ],
    ];
}
    /**
     * Listado principal (público o admin según rol).
     */
public function actionIndex()
{
    $user = Yii::$app->user->identity;
    $query = Coleccion::find()->with('usuario');

    // 1. ADMIN / GESTOR: Vista de administración completa
    if ($user && ($user->rol === 'admin' || $user->rol === 'gestor')) {
        return $this->render('admin', [
            'colecciones' => $query->all(),
            'esAdmin' => ($user->rol === 'admin')
        ]);
    }

    // 2. FILTRO DE PRIVACIDAD PARA ALUMNOS E INVITADOS
    if (Yii::$app->user->isGuest) {
        $query->andWhere(['tipo_acceso' => 'publico']);
    } else {
        // Mostramos: Todas las públicas + Las privadas que yo mismo creé
        $query->andWhere([
            'OR',
            ['tipo_acceso' => 'publico'],
            ['AND', ['tipo_acceso' => 'privado'], ['usuarioId' => $user->id]]
        ]);
    }

    // 3. MIS COLECCIONES: Cargamos las unidas para el lateral del index
    $misColecciones = [];
    if ($user && $user->rol === 'alumno') {
        $misColecciones = Coleccion::find()
            ->alias('c')
            ->leftJoin('usuario_coleccion uc', 'c.id = uc.coleccionId')
            ->where(['c.usuarioId' => $user->id]) // Las que yo he creado (Importadas o nuevas)
            ->orWhere(['uc.usuarioId' => $user->id]) // A las que me he unido
            ->groupBy('c.id') // Evita duplicados si soy autor y además estoy unido
            ->all();
    }

    return $this->render('index', [
        'colecciones' => $query->all(),
        'misColecciones' => $misColecciones,
    ]);
}

    /**
     * Ver contenido de una colección (Información + Documentos).
     */
    public function actionView($id, $docId = null)
{
    $coleccion = $this->findModel($id);
    $selectedDoc = null;

    // Si el usuario pulsó en "Ver Material", cargamos los datos del documento
    if ($docId) {
        $selectedDoc = \app\models\Documento::findOne($docId);
    }

    return $this->render('view', [
        'coleccion' => $coleccion,
        'selectedDoc' => $selectedDoc, // Pasamos el documento seleccionado a la vista
    ]);
}

    /**
     * Editar una colección existente.
     */
    public function actionUpdate($id)
{
    $model = $this->findModel($id);

    // COMPROBACIÓN DE PROPIEDAD
    if ($model->usuarioId !== Yii::$app->user->id && Yii::$app->user->identity->rol !== 'admin') {
        throw new \yii\web\ForbiddenHttpException('No tienes permiso para editar esta colección.');
    }

    if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
    }
    return $this->render('update', ['model' => $model]);
}

public function actionDelete($id)
{
    $model = $this->findModel($id);
    if ($model->usuarioId === Yii::$app->user->id || Yii::$app->user->identity->rol === 'admin') {
        $model->delete();
    }
    return $this->redirect(['index']);
}

    /**
     * Acción para que un alumno se una a una colección.
     */
    public function actionUnirse($id)
    {
        $usuarioId = Yii::$app->user->id;
        
        // Insertar en la tabla de unión usuario_coleccion
        Yii::$app->db->createCommand()->upsert('usuario_coleccion', [
            'usuarioId' => $usuarioId,
            'coleccionId' => $id,
        ])->execute();

        Yii::$app->session->setFlash('success', 'Te has unido correctamente a la colección.');
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Busca el modelo Coleccion o lanza error 404.
     */
    protected function findModel($id)
    {
        if (($model = Coleccion::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La colección solicitada no existe.');
    }

    public function actionDownload($id)
    {
        // 1. Buscamos la colección y sus relaciones
        $model = $this->findModel($id);

        // 2. Aumentamos el contador de descargas
        $model->updateCounters(['descargas' => 1]);

        // 3. Configuramos la librería PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // 4. Cargamos la vista de la plantilla inyectando los datos del modelo
        $html = $this->renderPartial('_pdf_template', [
            'model' => $model,
        ]);

        // 5. Generamos el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 6. El nombre del archivo será el título de la colección (limpio de espacios)
        $fileName = str_replace(' ', '_', $model->titulo) . '.pdf';

        return Yii::$app->response->sendContentAsFile(
            $dompdf->output(), 
            $fileName, 
            ['mimeType' => 'application/pdf']
        );
    }

    public function actionMisColecciones()
{
    $usuarioId = Yii::$app->user->id;
    // Buscamos las colecciones a través de la tabla de unión usuario_coleccion
    $colecciones = Coleccion::find()
        ->innerJoin('usuario_coleccion', 'coleccion.id = usuario_coleccion.coleccionId')
        ->where(['usuario_coleccion.usuarioId' => $usuarioId])
        ->all();

    return $this->render('mis_colecciones', [
        'colecciones' => $colecciones,
    ]);
}

public function actionCreate()
{
    $model = new Coleccion();
    if ($this->request->isPost) {
        if ($model->load($this->request->post())) {
            $model->usuarioId = Yii::$app->user->id;
            $model->fecha_actualizacion = date('Y-m-d H:i:s');

            if ($model->save()) {
                // UNIÓN AUTOMÁTICA: El creador se une a su propia colección
                Yii::$app->db->createCommand()->insert('usuario_coleccion', [
                    'usuarioId' => Yii::$app->user->id,
                    'coleccionId' => $model->id,
                    'fecha_union' => date('Y-m-d H:i:s'),
                ])->execute();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }
    return $this->render('create', ['model' => $model]);
}


public function actionAbandonar($id, $usuarioId = null)
{
    $coleccion = $this->findModel($id);
    // Verificamos si es admin usando la identidad del usuario
    $isAdmin = (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin');
    
    // Si se pasa usuarioId es una expulsión (hecha por admin), si no, es un abandono propio
    $targetUserId = $usuarioId ? $usuarioId : Yii::$app->user->id;

    // Validación: un alumno no puede abandonar su propia colección
    if (!$isAdmin && (int)$coleccion->usuarioId === (int)$targetUserId) {
        Yii::$app->session->setFlash('error', 'Eres el autor de esta colección, no puedes abandonarla.');
        return $this->redirect(['index']);
    }

    // 1. Eliminamos la relación en la tabla intermedia
    Yii::$app->db->createCommand()
        ->delete('usuario_coleccion', ['usuarioId' => $targetUserId, 'coleccionId' => $id])
        ->execute();

    // 2. Contamos cuántos usuarios quedan suscritos ahora
    $miembrosRestantes = (int) Yii::$app->db->createCommand(
        'SELECT COUNT(*) FROM usuario_coleccion WHERE coleccionId = :id'
    )->bindValue(':id', $id)->queryScalar();

    // 3. Caso especial: La colección se queda sin miembros
    if ($miembrosRestantes === 0) {
        $coleccion->delete(); // Borramos la colección de la base de datos
        Yii::$app->session->setFlash('warning', 'La colección se ha eliminado automáticamente al quedarse sin miembros.');
        
        /** * CLAVE: Redirigimos a 'index'. Como eres admin, la función actionIndex() 
         * detectará tu rol y cargará automáticamente 'admin.php'
         */
        return $this->redirect(['index']);
    }
    
    // 4. Redirección si la colección todavía tiene otros miembros
    if ($usuarioId && $isAdmin) {
        Yii::$app->session->setFlash('success', 'Usuario expulsado correctamente.');
        return $this->redirect(['usuarios', 'id' => $id]);
    } else {
        Yii::$app->session->setFlash('success', 'Has dejado la colección correctamente.');
        return $this->redirect(['index']);
    }
}

/**
 * Muestra la vista para elegir a qué colecciones añadir el documento
 */
public function actionAgregarMaterial($docId)
{
    // Buscamos el documento (usando su modelo) para mostrar info en la vista
    $documento = \app\models\Documento::findOne($docId);
    if (!$documento) throw new \yii\web\NotFoundHttpException();

    // Solo obtenemos las colecciones que el usuario logeado ha creado
    $misColeccionesCreadas = Coleccion::find()
        ->where(['usuarioId' => Yii::$app->user->id])
        ->all();

    return $this->render('agregar_material', [
        'documento' => $documento,
        'misColecciones' => $misColeccionesCreadas,
    ]);
}

/**
 * Procesa la inserción de la relación documento-colección
 */
public function actionGuardarMaterial($docId)
{
    $seleccionadas = Yii::$app->request->post('colecciones', []);
    $userId = Yii::$app->user->id;

    foreach ($seleccionadas as $colId) {
        // Verificamos por seguridad que la colección pertenece al usuario
        $esMia = Coleccion::find()->where(['id' => $colId, 'usuarioId' => $userId])->exists();
        
        if ($esMia) {
            // Evitamos duplicados antes de insertar
            $existe = (new \yii\db\Query())
                ->from('coleccion_documento')
                ->where(['coleccionId' => $colId, 'documentoId' => $docId])
                ->exists();

            if (!$existe) {
                Yii::$app->db->createCommand()->insert('coleccion_documento', [
                    'coleccionId' => $colId,
                    'documentoId' => $docId
                ])->execute();
            }
        }
    }

    Yii::$app->session->setFlash('success', 'Material añadido correctamente a tus colecciones.');
    return $this->redirect(['materiales/view', 'id' => $docId]); // Volvemos a la ficha del material
}

/**
 * Elimina la relación entre un documento y la colección
 */
public function actionQuitarMaterial($id, $docId)
{
    $coleccion = $this->findModel($id);

    // Seguridad: Solo el autor puede quitar materiales
    if ($coleccion->usuarioId !== Yii::$app->user->id && Yii::$app->user->identity->rol !== 'admin') {
        throw new \yii\web\ForbiddenHttpException('No tienes permiso para modificar esta colección.');
    }

    Yii::$app->db->createCommand()->delete('coleccion_documento', [
        'coleccionId' => $id,
        'documentoId' => $docId
    ])->execute();

    Yii::$app->session->setFlash('success', 'Material retirado de la colección.');
    return $this->redirect(['view', 'id' => $id]);
}

public function actionUsuarios($id)
{
    $coleccion = $this->findModel($id);
    $usuarios = $coleccion->getUsuarios()->all();

    return $this->render('usuarios', [
        'coleccion' => $coleccion,
        'usuarios' => $usuarios,
    ]);
}


}