<?php
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $creadasProvider */
/** @var yii\data\ActiveDataProvider $guardadasProvider */
?>

<div class="p-3">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0 text-primary"><i class="bi bi-folder-plus"></i> Mis Colecciones Creadas</h5>
        <?= Html::a('<i class="bi bi-plus-lg"></i> Nueva Colección', ['coleccion/create'], ['class' => 'btn btn-sm btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $creadasProvider,
        'summary' => '',
        'emptyText' => 'No has creado ninguna colección todavía.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'titulo',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a(Html::encode($model->titulo), ['coleccion/view', 'id' => $model->id], ['class' => 'fw-bold']);
                }
            ],
            [
                'attribute' => 'tipo_acceso',
                'label' => 'Privacidad',
                'value' => function($model) {
                    return ucfirst($model->tipo_acceso ?? 'público');
                }
            ],
            [
                'label' => 'Descargas',
                'attribute' => 'descargas',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'coleccion',
                'template' => '{view} {update} {delete}', // Autor tiene control total
            ],
        ],
    ]); ?>

    <hr class="my-5">

    <div class="mb-3">
        <h5 class="m-0 text-secondary"><i class="bi bi-bookmark-heart"></i> Colecciones Guardadas</h5>
        <small class="text-muted">Colecciones de otros usuarios que sigues.</small>
    </div>

    <?= GridView::widget([
        'dataProvider' => $guardadasProvider,
        'summary' => '',
        'emptyText' => 'No sigues ninguna colección.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'titulo',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a(Html::encode($model->titulo), ['coleccion/view', 'id' => $model->id], ['class' => 'text-decoration-none']);
                }
            ],
            [
                'label' => 'Autor',
                'value' => function($model) {
                    // Relación getUsuario() en Coleccion.php
                    return $model->usuario ? $model->usuario->nombre : 'Desconocido';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'coleccion',
                'template' => '{view} {remove}',
                'buttons' => [
                    'remove' => function ($url, $model, $key) {
                        // Acción personalizada para "Dejar de seguir"
                        return Html::a('<i class="bi bi-x-circle"></i> Dejar de seguir', ['coleccion/dejar-seguir', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-outline-danger',
                            'data-confirm' => '¿Ya no te interesa esta colección?',
                            'data-method' => 'post',
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>
