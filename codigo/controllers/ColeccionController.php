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
            'class' => AccessControl::class,
            'only' => ['create', 'update', 'delete', 'unirse', 'download'], // Añadimos download aquí
            'rules' => [
                // Reglas para Gestión (Admin y Gestor)
                [
                    'actions' => ['create', 'update', 'delete'],
                    'allow' => true,
                    'roles' => ['@'], 
                    'matchCallback' => function ($rule, $action) {
                        $user = Yii::$app->user->identity;
                        return $user->rol === 'admin' || $user->rol === 'gestor';
                    }
                ],
                // Reglas para Interacción (Cualquier usuario logueado con rol)
                [
                    'actions' => ['unirse', 'download'],
                    'allow' => true,
                    'roles' => ['@'], // Solo usuarios autenticados pueden descargar
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
                'unirse' => ['POST'],
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

    // 1. ADMIN / GESTOR: Vista de administración pura (sin lateral)
    if ($user && ($user->rol === 'admin' || $user->rol === 'gestor')) {
        return $this->render('admin', [
            'colecciones' => $query->all(),
            'esAdmin' => ($user->rol === 'admin')
        ]);
    }

    // 2. ALUMNOS: Cargamos sus suscripciones para el lateral
    $misColecciones = [];
    if ($user && $user->rol === 'alumno') {
        $misColecciones = Coleccion::find()
            ->innerJoin('usuario_coleccion', 'coleccion.id = usuario_coleccion.coleccionId')
            ->where(['usuario_coleccion.usuarioId' => $user->id])
            ->all();
    }

    // 3. RETORNO: Alumnos e Invitados comparten 'index.php' pero con datos distintos
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
     * Crear una nueva colección.
     */
    public function actionCreate()
    {
        $model = new Coleccion();
        $model->usuarioId = Yii::$app->user->id; // El autor es quien la crea

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Editar una colección existente.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = Yii::$app->user->identity;

        // Seguridad: El gestor solo edita sus propias colecciones, el admin todas
        if ($user->rol !== 'admin' && $model->usuarioId !== $user->id) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para editar esta colección.');
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Eliminar una colección.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $user = Yii::$app->user->identity;

        if ($user->rol === 'admin' || $model->usuarioId === $user->id) {
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


}