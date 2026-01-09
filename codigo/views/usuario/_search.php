<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UsuarioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-3">
             <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'rol')->dropDownList([
                'alumno' => 'Alumno',
                'gestor' => 'Gestor',
                'empresa' => 'Empresa',
                'admin' => 'Admin',
            ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-3" style="margin-top: 25px;">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
