<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="p-3">
    <h5 class="mb-3">Mis Preguntas y Respuestas</h5>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => 'No has participado en ningún debate aún.',
        'columns' => [
            [
                'attribute' => 'fecha',
                'format' => ['date', 'php:d M Y H:i'],
                'contentOptions' => ['style' => 'width: 150px; font-size: 0.9em; color: #666;']
            ],
            [
                'attribute' => 'contenido',
                'label' => 'Comentario',
                'format' => 'ntext',
            ],
            [
                'label' => 'En Documento',
                'format' => 'raw',
                'value' => function($model) {
                    // Asumiendo relación 'documento' en el modelo DocumentoComentario
                    return isset($model->documento) 
                        ? Html::a(Html::encode($model->documento->titulo), ['documento/view', 'id' => $model->documentoId]) 
                        : '<span class="text-muted">Desconocido</span>';
                }
            ]
        ],
    ]); ?>
</div>
