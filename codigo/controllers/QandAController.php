<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pregunta; // Importar modelo
use app\models\Respuesta; // Importar modelo
use yii\filters\AccessControl;

class QandaController extends Controller
{
    /**
     * Configuración de acceso (Opcional: define quién puede ver esto)
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@', '?'], // '@' para logueados, '?' para invitados. Ajusta según necesites.
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
            'sin_responder' => Pregunta::find()->where(['estado' => 'pending'])->count(),
            'respondida' => Pregunta::find()->where(['estado' => 'answered'])->count(),
            'resuelta' => Pregunta::find()->where(['estado' => 'resolved'])->count(),
        ];

        // 3. Renderizar la vista
        // Yii buscará automáticamente en: views/qanda/index.php
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
/**
     * Procesa el formulario de respuesta.
     */
    public function actionResponder($id)
    {
        $pregunta = Pregunta::findOne($id);
        if (!$pregunta) {
            throw new \yii\web\NotFoundHttpException();
        }

        // Si es un invitado, se muestra un mensaje de error
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesi�n para poder responder.');
            return $this->redirect(['view', 'id' => $id]);
        }

        // Si es un usario registrado hacemos el post
        if (Yii::$app->request->isPost) {
            $contenido = Yii::$app->request->post('contenido_respuesta');
            
            if (!empty($contenido)) {
                $respuesta = new Respuesta();
                $respuesta->pregunta_id = $pregunta->id;
                $respuesta->usuario_id = Yii::$app->user->id;
                $respuesta->contenido = $contenido;
                $respuesta->fecha_creacion = date('Y-m-d H:i:s');
                
                if ($respuesta->save()) {
                    Yii::$app->session->setFlash('success', '�Respuesta publicada!');
                    
                    // Cambiar estado a 'answered' si estaba pendiente
                    if ($pregunta->estado === 'pending') {
                        $pregunta->estado = 'answered';
                        $pregunta->save();
                    }
                    return $this->refresh(); // Evita el reenv�o del formulario al actualizar
                } else {
                    Yii::$app->session->setFlash('error', 'Error al guardar la respuesta.');
                }
            }
        }

        return $this->redirect(['view', 'id' => $id]);
    }

}
