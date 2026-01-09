<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Documento $model */

$this->title = 'Subir Nuevo Material';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">📤 Subir Documento</h2>
                    
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data'] // Para suibir archivos
                    ]); ?>

                    <?= $form->field($model, 'titulo')->textInput(['placeholder' => 'Ej: Apuntes de Física Cuántica', 'class' => 'form-control mb-3']) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'materiaId')->dropDownList($materias, ['prompt' => 'Selecciona Materia...', 'class' => 'form-select mb-3']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'tipo_acceso')->dropDownList([
                                'publico' => '🔓 Público (Apuntes)', 
                                'privado' => '🔒 Privado (Examen)'
                            ], ['class' => 'form-select mb-3']) ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'institucionId')->dropDownList($instituciones, ['prompt' => 'Selecciona Institución...', 'class' => 'form-select mb-3']) ?>

                    <?= $form->field($model, 'autorId')->dropDownList($autores, ['prompt' => 'Selecciona Autor/Profesor...', 'class' => 'form-select mb-3']) ?>

                    <div class="mb-4 p-3 bg-light rounded border border-dashed text-center">
                        <label class="form-label fw-bold d-block">Selecciona el PDF</label>
                        <?= $form->field($model, 'archivoFile')->fileInput(['class' => 'form-control'])->label(false) ?>
                        <small class="text-muted">Solo formato .pdf (Máx 10MB)</small>
                    </div>

                    <div class="d-grid gap-2">
                        <?= Html::submitButton('Subir Documento', ['class' => 'btn btn-primary btn-lg']) ?>
                        <a href="<?= \yii\helpers\Url::to(['materiales/index']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            
        </div>
    </div>
</div>