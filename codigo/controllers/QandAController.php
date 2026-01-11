<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pregunta;
use app\models\Respuesta;
use yii\filters\AccessControl;

class QandAController extends Controller
{
    /**
     * Comportamientos y Control de Acceso (ACL)
     * Define quién puede ejecutar qué acciones.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'responder'], // Solo protegemos crear y responder
                'rules' => [
                    // Permitir crear y responder solo a usuarios autenticados (@)
                    [
                        'actions' => ['create', 'responder'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // Permitir ver el índice y el detalle a todos (invitados ? y usuarios @)
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
     * Muestra la lista principal de preguntas.
     * URL: index.php?r=qand-a/index
     */
    public function actionIndex()
    {
        // 1. Obtener el término de búsqueda de la URL (si existe)
        $search = Yii::$app->request->get('q');

        // 2. Iniciar la consulta a la base de datos
        // Usamos 'with' para carga ansiosa de datos del usuario y evitar muchas consultas SQL
        $query = Pregunta::find()
            ->with(['usuario', 'respuestas']); 

        // 3. Aplicar filtro si el usuario escribió algo
        if ($search) {
            $query->andFilterWhere(['or',
                ['like', 'titulo', $search],
                ['like', 'descripcion', $search],
            ]);
        }

        // 4. Ejecutar la consulta (ordenada por fecha descendente)
        $preguntas = $query->orderBy(['fecha_creacion' => SORT_DESC])->all();

        // 5. Generar estadísticas para las tarjetas superiores
        // Nota: Calculamos esto sobre el total global, no sobre el filtro, para que los números informativos no cambien.
        $statsQuery = Pregunta::find(); 
        $resumen = [
            'total'         => (clone $statsQuery)->count(),
            'sin_responder' => (clone $statsQuery)->where(['estado' => 'sin_responder'])->count(),
            'respondida'    => (clone $statsQuery)->where(['estado' => 'respondida'])->count(),
            'resuelta'      => (clone $statsQuery)->where(['estado' => 'resuelta'])->count(),
        ];

        // 6. Renderizar la vista pasando los datos
        return $this->render('index', [
            'preguntas' => $preguntas,
            'resumen'   => $resumen,
            'search'    => $search, // Devolvemos el texto buscado para mostrarlo en el input
        ]);
    }

    /**
     * Muestra el detalle de una pregunta específica.
     * @param int $id ID de la pregunta
     */
    public function actionView($id)
    {
        // Buscar la pregunta por ID con sus respuestas cargadas
        $model = Pregunta::find()
            ->where(['id' => $id])
            ->with(['usuario', 'respuestas.usuario']) // Cargar autor y autores de respuestas
            ->one();

        // Si no existe, lanzar error 404
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('La pregunta solicitada no existe.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Crea una nueva pregunta.
     * Solo accesible por usuarios logueados (ver behaviors).
     */
    public function actionCreate()
    {
        $model = new Pregunta();

        // Si el formulario fue enviado (POST) y los datos son válidos
        if ($model->load(Yii::$app->request->post())) {
            
            // Asignar automáticamente el ID del usuario actual
            $model->usuarioId = Yii::$app->user->id;
            
            // Configurar valores por defecto
            $model->estado = 'sin_responder';
            $model->fecha_creacion = date('Y-m-d H:i:s');

            // Intentar guardar en la base de datos
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '¡Pregunta publicada con éxito!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Hubo un error al publicar la pregunta.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Acción para agregar una respuesta a una pregunta.
     * @param int $id ID de la pregunta a responder
     */
    public function actionResponder($id)
    {
        // Verificar que sea una petición POST
        if (Yii::$app->request->isPost) {
            
            $contenido = Yii::$app->request->post('contenido_respuesta');
            
            if (!empty($contenido)) {
                $respuesta = new Respuesta();
                $respuesta->preguntaId = $id;
                $respuesta->usuarioId = Yii::$app->user->id;
                $respuesta->contenido = $contenido;
                $respuesta->fecha = date('Y-m-d H:i:s');

                if ($respuesta->save()) {
                    // Actualizar estado de la pregunta a 'respondida' si estaba 'sin_responder'
                    $pregunta = Pregunta::findOne($id);
                    if ($pregunta && $pregunta->estado === 'sin_responder') {
                        $pregunta->estado = 'respondida';
                        $pregunta->save();
                    }

                    Yii::$app->session->setFlash('success', 'Tu respuesta ha sido publicada.');
                } else {
                    Yii::$app->session->setFlash('error', 'No se pudo guardar la respuesta.');
                }
            } else {
                Yii::$app->session->setFlash('warning', 'La respuesta no puede estar vacía.');
            }
        }

        // Redirigir de vuelta a la vista de la pregunta
        return $this->redirect(['view', 'id' => $id]);
    }
}
