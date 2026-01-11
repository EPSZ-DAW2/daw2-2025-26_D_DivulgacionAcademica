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
}
