<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */

// 1. SECURITY CHECK: Am I an Admin?
$isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin';
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
            <div class="alert alert-warning p-2 mt-3">
                <small>Dejar la contraseña en blanco para mantener la actual.</small>
            </div>
            
            <?php 
            // CORRECCIÓN: Usamos 'password_plain' para que no falle la validación si está vacío
            echo $form->field($model, 'password_plain')->passwordInput(['maxlength' => true])->label('Nueva Contraseña'); 
            ?>

        </div>
    </div>

    <div class="form-group mt-4">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
