<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pregunta */

$this->title = 'Hacer una pregunta';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

<div class="form-group">
    <?= Html::submitButton('Publicar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

