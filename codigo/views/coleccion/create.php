<?php
use yii\helpers\Html;

$this->title = 'Crear Nueva Colección';
?>
<div class="container">
    <div class="page-header mb-8">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <p class="page-description">Define una nueva agrupación temática de materiales académicos.</p>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>