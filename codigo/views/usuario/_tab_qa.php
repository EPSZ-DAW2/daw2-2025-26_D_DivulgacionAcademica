<?php
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $preguntasProvider */
/** @var yii\data\ActiveDataProvider $respuestasProvider */
?>

<div class="p-3">
    
    <div class="mb-4">
        <h5 class="text-primary"><i class="bi bi-question-circle"></i> Mis Preguntas</h5>
        <?= GridView::widget([
            'dataProvider' => $preguntasProvider,
            'summary' => '',
            'emptyText' => 'No has realizado ninguna pregunta.',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'titulo', // Ajusta si el campo se llama distinto
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a(Html::encode($model->titulo ?? 'Sin título'), ['qand-a/view', 'id' => $model->id]);
                    }
                ],
                [
                    'attribute' => 'materiaId',
                    'label' => 'Materia',
                    'value' => function($model) {
                        return $model->materia ? $model->materia->nombre : 'General';
                    }
                ],
                [
                    'label' => 'Respuestas',
                    'value' => function($model) {
                        // Usando la relación getRespuestas() que mostraste
                        return count($model->respuestas); 
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'controller' => 'pregunta',
                ],
            ],
        ]); ?>
    </div>

    <hr>

    <div>
        <h5 class="text-success"><i class="bi bi-check-circle"></i> Mis Respuestas Aportadas</h5>
        <?= GridView::widget([
            'dataProvider' => $respuestasProvider,
            'summary' => '',
            'emptyText' => 'No has aportado respuestas aún.',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'contenido', // Ajusta si se llama 'cuerpo' o similar
                    'label' => 'Tu Respuesta',
                    'format' => 'ntext',
                    'value' => function($model) {
                        return \yii\helpers\StringHelper::truncate($model->contenido ?? '', 60);
                    }
                ],
                [
                    'label' => 'En respuesta a',
                    'format' => 'raw',
                    'value' => function($model) {
                        // Asumiendo que Respuesta tiene 'preguntaId' y relación 'pregunta'
                        // Si no la tiene en el modelo, agrégala: public function getPregunta() { return $this->hasOne(Pregunta::class, ['id' => 'preguntaId']); }
                        if (isset($model->pregunta)) {
                            return Html::a(Html::encode($model->pregunta->titulo), ['pregunta/view', 'id' => $model->pregunta->id]);
                        }
                        return '<span class="text-muted">Pregunta eliminada</span>';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'controller' => 'respuesta', // O redirige a la pregunta
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            // Redirigir a la pregunta original en lugar de ver la respuesta aislada
                            $preguntaId = $model->preguntaId ?? $model->pregunta_id ?? null;
                            if ($preguntaId) {
                                return Html::a('<i class="bi bi-eye"></i>', ['pregunta/view', 'id' => $preguntaId, '#' => 'respuesta-'.$model->id], ['class' => 'btn btn-sm btn-light']);
                            }
                            return '';
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>

</div>
