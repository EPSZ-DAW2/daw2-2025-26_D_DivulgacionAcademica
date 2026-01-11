<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Debug Usuario';
?>
<div class="usuario-debug">
    <h1>Debug Usuario</h1>
    
    <h2>Atributos del modelo:</h2>
    <pre><?= print_r($model->attributes, true) ?></pre>
    
    <h2>Errores:</h2>
    <pre><?= print_r($model->errors, true) ?></pre>
    
    <h2>Datos en BD:</h2>
    <?php 
    $usuarioDb = app\models\Usuario::findOne($model->id);
    if ($usuarioDb): ?>
        <pre><?= print_r($usuarioDb->attributes, true) ?></pre>
    <?php endif; ?>
    
    <hr>
    
    <?= Html::a('Volver a Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div>