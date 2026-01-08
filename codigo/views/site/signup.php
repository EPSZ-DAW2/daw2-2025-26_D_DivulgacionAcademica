<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm; // Asegúrate de usar bootstrap5 o bootstrap4 según tu versión de Yii2

$this->title = 'Registrarse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, rellene los siguientes campos para registrarse:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Nombre de Usuario') ?>

                <?= $form->field($model, 'nombre')->label('Nombre') ?>

                <?= $form->field($model, 'apellidos')->label('Apellidos') ?>

                <?= $form->field($model, 'email')->label('Correo Electrónico') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>

                <div class="form-group">
                    <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
