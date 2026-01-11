<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pregunta;
use app\models\Respuesta;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper; // Necesario para mostrar errores legibles

class QandAController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'responder', 'admin', 'delete-pregunta', 'delete-respuesta'],
                'rules' => [
                    [
                        'actions' => ['create', 'responder'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['admin', 'delete-pregunta', 'delete-respuesta'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $search = Yii::$app->request->get('q');
        $query = Pregunta::find()->with(['usuario', 'respuestas']); 

        if ($search) {
            $query->andFilterWhere(['or',
                ['like', 'titulo', $search],
                ['like', 'descripcion', $search],
            ]);
        }

        $preguntas = $query->orderBy(['fecha_creacion' => SORT_DESC])->all();

        // Estadísticas
        $statsQuery = Pregunta::find(); 
        $resumen = [
            'total'         => (clone $statsQuery)->count(),
            'sin_responder' => (clone $statsQuery)->where(['estado' => 'sin_responder'])->count(),
            'respondida'    => (clone $statsQuery)->where(['estado' => 'respondida'])->count(),
            'resuelta'      => (clone $statsQuery)->where(['estado' => 'resuelta'])->count(),
        ];

        return $this->render('index', [
            'preguntas' => $preguntas,
            'resumen'   => $resumen,
            'search'    => $search,
        ]);
    }

    public function actionAdmin()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pregunta::find()->with('usuario'),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['fecha_creacion' => SORT_DESC]],
        ]);

        return $this->render('admin', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = Pregunta::find()
            ->where(['id' => $id])
            ->with(['usuario', 'respuestas.usuario'])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('La pregunta no existe.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * ACCIÓN CREAR MEJORADA CON DEBUG
     */
    public function actionCreate()
    {
        $model = new Pregunta();

        if ($model->load(Yii::$app->request->post())) {
            $model->usuarioId = Yii::$app->user->id;
            $model->estado = 'sin_responder';
            $model->fecha_creacion = date('Y-m-d H:i:s');
            
            // Si tienes un campo materiaId obligatorio en la BD pero no en el form,
            // esto podría fallar. Asegúrate de manejarlo o poner un valor por defecto:
            // $model->materiaId = 1; // Descomenta si es necesario un valor por defecto

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Pregunta publicada con éxito.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                // DEBUG: Muestra exactamente por qué falló
                $errores = implode('<br>', ArrayHelper::getColumn($model->getErrors(), 0));
                Yii::$app->session->setFlash('error', '<b>No se pudo publicar:</b><br>' . $errores);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * ACCIÓN RESPONDER MEJORADA CON DEBUG
     */
    public function actionResponder($id)
    {
        if (Yii::$app->request->isPost) {
            $contenido = Yii::$app->request->post('contenido_respuesta');
            
            if (!empty($contenido)) {
                $respuesta = new Respuesta();
                $respuesta->preguntaId = $id;
                $respuesta->usuarioId = Yii::$app->user->id;
                $respuesta->contenido = $contenido;
                $respuesta->fecha = date('Y-m-d H:i:s');

                if ($respuesta->save()) {
                    // Actualizar estado de la pregunta
                    $pregunta = Pregunta::findOne($id);
                    if ($pregunta && $pregunta->estado === 'sin_responder') {
                        $pregunta->estado = 'respondida';
                        $pregunta->save();
                    }
                    Yii::$app->session->setFlash('success', 'Tu respuesta ha sido publicada.');
                } else {
                    // DEBUG: Muestra errores de la respuesta
                    $errores = implode('<br>', ArrayHelper::getColumn($respuesta->getErrors(), 0));
                    Yii::$app->session->setFlash('error', '<b>Error al guardar respuesta:</b><br>' . $errores);
                }
            } else {
                Yii::$app->session->setFlash('warning', 'La respuesta no puede estar vacía.');
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDeletePregunta($id)
    {
        $model = Pregunta::findOne($id);
        if ($model) {
            Respuesta::deleteAll(['preguntaId' => $id]);
            $model->delete();
            Yii::$app->session->setFlash('success', 'Hilo eliminado correctamente.');
        }
        return $this->redirect(['admin']);
    }

    public function actionDeleteRespuesta($id)
    {
        $respuesta = Respuesta::findOne($id);
        if ($respuesta) {
            $preguntaId = $respuesta->preguntaId;
            $respuesta->delete();
            Yii::$app->session->setFlash('success', 'Respuesta eliminada.');
            return $this->redirect(['view', 'id' => $preguntaId]);
        }
        throw new NotFoundHttpException();
    }
}
