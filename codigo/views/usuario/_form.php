<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */

$isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin';
$isNew = $model->isNewRecord;
$esPropioPerfil = !Yii::$app->user->isGuest && Yii::$app->user->id == $model->id;
$mostrarConfirmacion = !$isNew && $esPropioPerfil;
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin([
        'id' => 'usuario-update-form',
        'enableClientValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username')->textInput([
                'maxlength' => true, 
                'readonly' => !$isAdmin && !$isNew 
            ])->label('Nombre de Usuario') ?>

            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label('Nombre Completo') ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?php if ($isAdmin): ?>
                <div class="p-3 mb-3 bg-light border rounded">
                    <strong style="display: block; margin-bottom: 10px; color: #495057;">Zona de Administración</strong>
                    <?= $form->field($model, 'rol')->dropDownList([
                        'alumno' => 'Alumno',
                        'gestor' => 'Gestor',
                        'empresa' => 'Empresa',
                        'admin' => 'Administrador',
                    ], ['prompt' => 'Seleccione un Rol...']) ?>
                </div>
            <?php endif; ?>
            
            <div class="alert alert-info p-2 mt-3" style="font-size: 0.85rem;">
                <i class="bi bi-info-circle"></i> <small>Escribe aquí solo si deseas cambiar la contraseña actual.</small>
            </div>
            
            <?= $form->field($model, 'password_plain')->passwordInput([
                'maxlength' => true, 
                'placeholder' => 'Dejar en blanco para mantener la actual...'
            ])->label('Nueva Contraseña') ?>
        </div>
    </div>
    
    
    <div class="form-group mt-5 text-center">
        <?= Html::submitButton($isNew ? 'Crear Usuario' : 'Guardar Cambios', [
            'class' => 'btn btn-success px-5 py-2',
            'style' => 'font-weight: 700; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>