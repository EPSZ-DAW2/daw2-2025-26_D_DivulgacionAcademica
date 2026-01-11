<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pregunta; // Importar modelo
use app\models\Respuesta; // Importar modelo
use yii\filters\AccessControl;

class QandAController extends Controller
{
    /**
     * Configuración de acceso (Opcional: define quién puede ver esto)
     */
    public function behaviors()
	{
		return [
		    'access' => [
		        'class' => AccessControl::class,
		        'only' => ['create', 'responder'], // solo proteger estas acciones
		        'rules' => [
		            // crear y responder solo para usuarios logueados
		            [
		                'actions' => ['create', 'responder'],
		                'allow' => true,
		                'roles' => ['@'],
		            ],
		            // index y view accesibles para todos
		            [
		                'actions' => ['index', 'view'],
		                'allow' => true,
		                'roles' => ['@', '?'],
		            ],
		        ],
		    ],
		];
	}


    /**
     * Muestra la página principal de Q&A
     * URL: index.php?r=qanda/index
     */
    public function actionIndex()
	{
		// 1. Obtener preguntas
		$preguntas = Pregunta::find()
		    ->with(['usuario', 'respuestas.usuario'])
		    ->orderBy(['fecha_creacion' => SORT_DESC])
		    ->all();

		// 2. Generar resumen
		$resumen = [
		    'total' => Pregunta::find()->count(),
		    'sin_responder' => Pregunta::find()->where(['estado' => 'sin_responder'])->count(),
		    'respondida' => Pregunta::find()->where(['estado' => 'respondida'])->count(),
		    'resuelta' => Pregunta::find()->where(['estado' => 'resuelta'])->count(),
		];

		// 3. Renderizar la vista
		return $this->render('index', [
		    'preguntas' => $preguntas,
		    'resumen' => $resumen,
		]);
	}


/**
     * Muestra el detalle de una pregunta.
     * @param int $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Pregunta::findOne($id);
        
        if (!$model) {
            throw new \yii\web\NotFoundHttpException("La pregunta no existe.");
        }

        // Renderizamos la vista 'view.php' que acabamos de crear
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Procesa el formulario de respuesta.
     */
    public function actionResponder($id)
    {
        $pregunta = Pregunta::findOne($id);
        if (!$pregunta) {
            throw new \yii\web\NotFoundHttpException();
        }

        if (Yii::$app->request->isPost) {
            $contenido = Yii::$app->request->post('contenido_respuesta');
            
            if (!empty($contenido)) {
                $respuesta = new Respuesta();
                $respuesta->pregunta_id = $pregunta->id;
                $respuesta->usuario_id = Yii::$app->user->id;
                $respuesta->contenido = $contenido;
                // $respuesta->fecha_creacion = date('Y-m-d H:i:s'); // Si tu BD no lo pone automático
                
                if ($respuesta->save()) {
                    Yii::$app->session->setFlash('success', '¡Respuesta publicada!');
                    
                    // Cambiar estado a 'answered' si estaba pendiente
                    if ($pregunta->estado === 'pending') {
                        $pregunta->estado = 'answered';
                        $pregunta->save();
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Error al guardar la respuesta.');
                }
            }
        }

        return $this->redirect(['view', 'id' => $id]);
    }
	
	/**
	 * Crear una nueva pregunta
	 * URL: index.php?r=qanda/create
	 */
	public function actionCreate()
	{
		$model = new Pregunta();

		// Verificar si se envió POST
		if (Yii::$app->request->isPost) {

		    // Cargar datos del POST en el modelo
		    if ($model->load(Yii::$app->request->post())) {

		        // Asignar usuario logueado
		        if (!Yii::$app->user->isGuest) {
		            $model->usuarioId = Yii::$app->user->id;
		        } else {
		            Yii::$app->session->setFlash('error', 'Debes estar logueado para publicar una pregunta.');
		            return $this->redirect(['index']);
		        }

		        // Asignar estado inicial y fecha de creación
		        $model->estado = 'sin_responder';
		        $model->fecha_creacion = date('Y-m-d H:i:s');

		        // Guardar en la base de datos
		        if ($model->save()) {
		            Yii::$app->session->setFlash('success', '¡Pregunta publicada!');
		            return $this->redirect(['view', 'id' => $model->id]);
		        } else {
		            // Depuración: mostrar errores si falla la validación
		            Yii::$app->session->setFlash(
		                'error', 
		                'No se pudo guardar la pregunta: ' . implode(', ', array_map(function($err){ return implode('; ', $err); }, $model->getErrors()))
		            );
		        }
		    } else {
		        // Depuración: si load() falla
		        Yii::$app->session->setFlash('error', 'No se pudieron cargar los datos del formulario. Verifica que los campos tengan el nombre correcto.');
		    }
		}

		// Renderizar formulario
		return $this->render('create', [
		    'model' => $model,
		]);
	}
}
