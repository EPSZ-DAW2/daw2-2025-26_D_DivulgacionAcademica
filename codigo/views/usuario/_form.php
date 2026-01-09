<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */
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
            
            <?= $form->field($model, 'rol')->dropDownList([
                'alumno' => 'Alumno',
                'gestor' => 'Gestor',
                'empresa' => 'Empresa',
                'admin' => 'Administrador',
            ], ['prompt' => 'Seleccione un Rol...']) ?>

            <div class="alert alert-warning p-2 mt-3">
                <small>Dejar la contraseña en blanco para mantener la actual (solo en edición).</small>
            </div>
            
            <?php 
            // Usamos 'password' tal cual está en tu base de datos.
            // Nota: En un sistema real, idealmente usarías un campo virtual 'plainPassword' en el modelo.
            echo $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']); 
            ?>

        </div>
    </div>

    <div class="form-group mt-4">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
