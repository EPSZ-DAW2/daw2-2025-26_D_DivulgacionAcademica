<?php
use yii\helpers\Html;

$this->title = 'Editar Colección: ' . $model->titulo;
?>
<div class="container">
    <div class="page-header mb-8">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <p class="page-description">Actualiza la información o la visibilidad de esta colección.</p>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>