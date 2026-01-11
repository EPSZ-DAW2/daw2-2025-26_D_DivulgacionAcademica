<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Colecciones Guardadas</h5>
        <?= Html::a('<i class="bi bi-plus"></i> Nueva', ['coleccion/create'], ['class' => 'btn btn-sm btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => 'No tienes colecciones guardadas.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'titulo',
                'label' => 'Colección',
                'format' => 'raw',
                'value' => function($model) {
                    // Ajusta según si el provider trae 'Coleccion' o 'UsuarioColeccion'
                    // Si es Coleccion directa:
                    return Html::a(Html::encode($model->titulo), ['coleccion/view', 'id' => $model->id], ['class' => 'fw-bold text-decoration-none']);
                }
            ],
            [
                'label' => 'Fecha',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->fecha_actualizacion ?? date('Y-m-d'));
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'controller' => 'coleccion', // Apunta al controlador correcto
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-trash"></i>', ['coleccion/remove', 'id' => $model->id], [
                            'data-confirm' => '¿Dejar de seguir esta colección?',
                            'data-method' => 'post',
                            'class' => 'text-danger'
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
