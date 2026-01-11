<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Administración de Preguntas y Respuestas';
?>
<div class="qanda-admin container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-danger"><i class="bi bi-shield-lock-fill"></i> <?= Html::encode($this->title) ?></h1>
        <?= Html::a('Ir a Vista Pública', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i> Estás en modo administrador. Las eliminaciones son irreversibles.
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => '',
                'tableOptions' => ['class' => 'table table-hover align-middle'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'titulo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a(Html::encode($model->titulo), ['view', 'id' => $model->id], ['target' => '_blank', 'class' => 'fw-bold text-decoration-none']);
                        }
                    ],
                    [
                        'attribute' => 'usuarioId',
                        'label' => 'Autor',
                        'value' => function($model) {
                            return $model->usuario ? $model->usuario->username : 'Anónimo';
                        }
                    ],
                    [
                        'label' => 'Respuestas',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center'],
                        'value' => function($model) {
                            return count($model->respuestas);
                        }
                    ],
                    [
                        'attribute' => 'fecha_creacion',
                        'format' => ['date', 'php:d/m/Y H:i'],
                        'label' => 'Fecha'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Acciones',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="bi bi-trash"></i> Eliminar', ['delete-pregunta', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de borrar esta pregunta y TODAS sus respuestas?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
