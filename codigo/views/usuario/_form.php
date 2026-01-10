<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */

// 1. SECURITY CHECK: Am I an Admin?
$isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin';
$isNew = $model->isNewRecord;
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            
            <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Nombre de Usuario') ?>

            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label('Nombre Completo') ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-md-6">
            
            <?php if ($isAdmin): ?>
                <div class="p-3 mb-3 bg-light border rounded">
                    <strong>Zona de Administración</strong>
                    <?= $form->field($model, 'rol')->dropDownList([
                        'alumno' => 'Alumno',
                        'gestor' => 'Gestor',
                        'empresa' => 'Empresa',
                        'admin' => 'Administrador',
                    ], ['prompt' => 'Seleccione un Rol...']) ?>
                </div>
            <?php endif; ?>
            
            <div class="alert alert-info p-2 mt-3">
                <small>Escribe aquí solo si deseas cambiar tu contraseña.</small>
            </div>
            
            <?= $form->field($model, 'password_plain')->passwordInput(['maxlength' => true, 'placeholder' => 'Nueva contraseña...']) ?>

        </div>
    </div>
    
    <?php if (!$isNew): ?>
        <hr>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6 p-4" style="background-color: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px;">
                <h5 class="text-center text-warning-emphasis">Confirmar cambios</h5>
                <p class="text-center small">Introduce tu contraseña actual para guardar.</p>
                
                <?= $form->field($model, 'current_password')->passwordInput([
                    'maxlength' => true,
                    'placeholder' => 'Tu contraseña actual...'
                ])->label(false) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group mt-4 text-center">
        <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-success px-5']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
