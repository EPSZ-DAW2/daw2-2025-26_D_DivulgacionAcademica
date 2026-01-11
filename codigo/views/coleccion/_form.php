<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\widgets\ActiveForm $form */
/** @var app\models\Coleccion $model */
?>

<div class="card shadow-md">
    <div class="card__header bg-secondary">
        <h3 class="card__title mt-0 mb-0" style="font-size: var(--font-size-lg)">
            Detalles de la Colección
        </h3>
    </div>

    <div class="card__body p-8">
        <?php $form = ActiveForm::begin([
            'id' => 'coleccion-form',
            'fieldConfig' => [
                // Ajustamos el template para asegurar que cada elemento respete el flujo de bloque
                'template' => "<div class=\"form-group mb-6\">{label}\n{input}\n{error}</div>",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-input'],
                'errorOptions' => ['class' => 'form-error'],
            ],
        ]); ?>

        <div class="grid grid--cols-1 gap-2">
            
            <?= $form->field($model, 'titulo')->textInput([
                'placeholder' => 'Ej: Fundamentos de Ciberseguridad',
                'maxlength' => true,
                'autofocus' => true,
            ])->label('Título de la colección <span class="text-tertiary" style="font-weight: normal">(Requerido)</span>') ?>

            <?= $form->field($model, 'descripcion')->textarea([
                'class' => 'form-textarea',
                'rows' => 5,
                'placeholder' => 'Describe brevemente qué materiales se encontrarán aquí...'
            ]) ?>

            <?= $form->field($model, 'tipo_acceso')->dropDownList([
                'publico' => '🔓 Pública (Visible para todos)',
                'privado' => '🔒 Privada (Solo para mi)',
            ], ['class' => 'form-input']) ?>

            <div class="flex items-center justify-between mt-8 pt-6" style="border-top: 1px solid var(--color-gray-200)">
                <div class="flex gap-4">
                    <?= Html::submitButton(
                        $model->isNewRecord ? 'Crear Colección' : 'Actualizar Cambios', 
                        ['class' => 'btn btn--primary']
                    ) ?>
                    <?= Html::a('Volver al listado', ['index'], ['class' => 'btn btn--ghost']) ?>
                </div>
                
                <?php if (!$model->isNewRecord): ?>
                    <span class="text-tertiary" style="font-size: var(--font-size-xs)">
                        Última edición: <?= Yii::$app->formatter->asDate($model->fecha_actualizacion) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>