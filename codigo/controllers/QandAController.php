<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pregunta;
use app\models\Respuesta;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class QandAController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'responder', 'admin', 'delete-pregunta', 'delete-respuesta'],
                'rules' => [
                    // Usuarios logueados pueden crear y responder
                    [
                        'actions' => ['create', 'responder'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // SOLO ADMIN: Panel, Borrar Pregunta, Borrar Respuesta
                    [
                        'actions' => ['admin', 'delete-pregunta', 'delete-respuesta'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Verificación directa del rol en la BD
                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin';
                        }
                    ],
                    // Index y View son públicos
                ],
            ],
        ];
    }

    // ... (actionIndex, actionCreate, actionResponder se mantienen igual) ...

    /**
     * DASHBOARD DE ADMINISTRACIÓN
     */
    public function actionAdmin()
    {
        // No necesitamos pasar $esAdmin a la vista porque la vista comprobará
        // Yii::$app->user->identity->rol si es necesario, pero como esta acción
        // está protegida por el 'matchCallback' de arriba, sabemos que quien entra es admin.
        
        $dataProvider = new ActiveDataProvider([
            'query' => Pregunta::find()->with('usuario'),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['fecha_creacion' => SORT_DESC]],
        ]);

        return $this->render('admin', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    // ... (Resto de acciones delete-pregunta, delete-respuesta) ...
    public function actionDeletePregunta($id)
    {
        $model = Pregunta::findOne($id);
        if ($model) {
            Respuesta::deleteAll(['preguntaId' => $id]);
            $model->delete();
            Yii::$app->session->setFlash('success', 'Pregunta eliminada.');
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
    
    public function actionIndex()
    {
        // 1. Obtener el término de búsqueda de la URL (si existe)
        $search = Yii::$app->request->get('q');

        // 2. Iniciar la consulta a la base de datos
        $query = Pregunta::find()
            ->with(['usuario', 'respuestas']); 

        // 3. Aplicar filtro si hay búsqueda
        if ($search) {
            $query->andFilterWhere(['or',
                ['like', 'titulo', $search],
                ['like', 'descripcion', $search],
            ]);
        }

        // 4. Obtener los resultados
        $preguntas = $query->orderBy(['fecha_creacion' => SORT_DESC])->all();

        // 5. Generar el resumen de estadísticas (ESTO ES LO QUE TE FALTABA)
        // Usamos una consulta nueva para contar el total global, sin filtros
        $statsQuery = Pregunta::find(); 
        
        $resumen = [
            'total'         => (clone $statsQuery)->count(), // <--- Aquí se define la clave 'total'
            'sin_responder' => (clone $statsQuery)->where(['estado' => 'sin_responder'])->count(),
            'respondida'    => (clone $statsQuery)->where(['estado' => 'respondida'])->count(),
            'resuelta'      => (clone $statsQuery)->where(['estado' => 'resuelta'])->count(),
        ];

        // 6. Enviar datos a la vista
        return $this->render('index', [
            'preguntas' => $preguntas,
            'resumen'   => $resumen, // Enviamos el array completo
            'search'    => $search,
        ]);
    }

    public function actionView($id) { 
        $model = Pregunta::find()->where(['id' => $id])->with(['usuario', 'respuestas.usuario'])->one();
        if(!$model) throw new NotFoundHttpException();
        return $this->render('view', ['model' => $model]); 
    }
    public function actionCreate() { /* ... tu código ... */ return $this->render('create', ['model' => new Pregunta()]); }
    public function actionResponder($id) { /* ... tu código ... */ return $this->redirect(['view', 'id' => $id]); }
}
