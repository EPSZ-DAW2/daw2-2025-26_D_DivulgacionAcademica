<?php
use yii\helpers\Url;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Coleccion[] $colecciones */

$this->title = 'Mis Colecciones Guardadas';
?>

<main id="main-content" class="main" role="main">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
            <p class="page-description">Aquí encontrarás todos los materiales y temas a los que te has unido recientemente.</p>
        </div>

        <?php if (empty($colecciones)): ?>
            <div class="alert alert--info flex flex-column align-center p-12">
                <p class="mb-6" style="font-size: var(--font-size-lg);">Todavía no te has unido a ninguna colección académica.</p>
                <?= Html::a('Explorar todas las colecciones', ['index'], ['class' => 'btn btn--primary']) ?>
            </div>
        <?php else: ?>
            <div class="grid grid--cols-1 grid--md-cols-2 grid--lg-cols-3">
                <?php foreach ($colecciones as $col): ?>
                    <article class="collection-card card h-full flex flex-column">
                        <div class="card__header collection-card__header flex-1">
                            <div class="flex justify-between align-center mb-3">
                                <span class="badge badge--success">✓ Guardada</span>
                                <span class="badge badge--secondary"><?= count($col->documentos) ?> Materiales</span>
                            </div>
                            
                            <h3 class="collection-card__title">
                                <?= Html::a(Html::encode($col->titulo), ['view', 'id' => $col->id]) ?>
                            </h3>
                            
                            <p class="collection-card__description">
                                <?= Html::encode($col->descripcion) ?>
                            </p>
                        </div>
                        
                        <div class="card__footer bg-secondary">
                            <div class="collection-card__meta mb-4">
                                <span>&#128100; Autor: <strong><?= Html::encode($col->usuario->nombre) ?></strong></span>
                                <span>&#11015;&#65039; <?= $col->descargas ?> descargas</span>
                                <span>&#128197; Act: <?= Yii::$app->formatter->asDate($col->fecha_actualizacion) ?></span>
                            </div>
                            
                            <?= Html::a('Continuar Aprendiendo', ['view', 'id' => $col->id], [
                                'class' => 'btn btn--outline btn--sm btn--block'
                            ]) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="mt-12 flex justify-center">
                <?= Html::a('&larr; Volver al Explorador General', ['index'], ['class' => 'btn btn--ghost']) ?>
            </div>
        <?php endif; ?>
    </div>
</main>