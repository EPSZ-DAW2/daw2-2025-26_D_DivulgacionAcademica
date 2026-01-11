<?php
use yii\helpers\Html;

$this->title = 'Actualizar Usuario: ' . $model->username;
?>
<div class="container">
    <div class="page-header mb-8">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <p class="page-description">Modifica los datos del perfil de usuario o sus permisos.</p>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>