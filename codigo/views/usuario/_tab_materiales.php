<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'titulo',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a(Html::encode($model->titulo), ['documento/view', 'id' => $model->id]);
                }
            ],
            'tipo_acceso',
            [
                'label' => 'Acciones',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a('Ver', ['documento/view', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-secondary']);
                }
            ]
        ],
    ]); ?>
</div>
