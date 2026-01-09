<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Coleccion $coleccion */

$this->title = $coleccion->titulo;
?>

<div class="container">
    <header class="collection-detail__header mb-8">
        <div class="flex justify-between align-center flex-wrap gap-6">
            <div class="flex-1">
                <h1 class="collection-detail__title mb-2"><?= Html::encode($this->title) ?></h1>
                <div class="collection-detail__meta">
                    <span>&#128100; Curada por <strong><?= Html::encode($coleccion->usuario->nombre) ?></strong></span>
                    <span>&#128197; Actualizada: <?= Yii::$app->formatter->asDate($coleccion->fecha_actualizacion) ?></span>
                    <span class="badge badge--inverse">&#11015;&#65039; <?= $coleccion->descargas ?> descargas</span>
                </div>
            </div>

            <div class="flex gap-4">
                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a('&#128274; Inicia sesión para descargar', ['site/login'], [
                        'class' => 'btn btn--white',
                        'style' => 'color: var(--color-error); font-weight: bold;',
                ]) ?>
                <?php else: ?>
                    <?= Html::a('&#11015;&#65039; Descargar PDF', ['download', 'id' => $coleccion->id], [
                        'class' => 'btn btn--white',
                        'style' => 'color: var(--color-primary); font-weight: bold;',
                ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="materials-layout">
        <div class="flex-column gap-6">
            <h2 class="section-title mb-6">Materiales incluidos</h2>
            
            <?php if (!empty($coleccion->documentos)): ?>
                <div class="grid grid--cols-1 grid--md-cols-2 gap-6">
                    <?php foreach ($coleccion->documentos as $doc): ?>
                        <article class="card flex flex-column">
                            <div class="card__body flex-1">
                                <div class="flex justify-between align-center mb-4">
                                    <span class="badge badge--primary"><?= strtoupper($doc->tipo_acceso) ?></span>
                                    <span class="text-tertiary" style="font-size: var(--font-size-xs)">Ref: #<?= $doc->id ?></span>
                                </div>
                                <h3 class="material-card__title" style="font-size: var(--font-size-lg)">
                                    <?= Html::encode($doc->titulo) ?>
                                </h3>
                                <p class="material-card__meta mt-4">
                                    <span class="material-card__category">&#128193; Materia ID: <?= $doc->materiaId ?></span>
                                </p>
                            </div>
                            <div class="card__footer bg-secondary">
                                <?= Html::a('Ver Material', ['documento/view', 'id' => $doc->id], [
                                    'class' => 'btn btn--ghost btn--sm btn--block'
                                ]) ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert--info">
                    <p class="mb-0">Esta colección todavía no tiene materiales académicos vinculados.</p>
                </div>
            <?php endif; ?>
        </div>

        <aside class="filters-sidebar">
            <h3 class="filters__title">Sobre esta colección</h3>
            <div class="material-description">
                <p><?= nl2br(Html::encode($coleccion->descripcion)) ?></p>
            </div>
            
            <div class="flex flex-column gap-4 mt-8 pt-6" style="border-top: 1px solid var(--color-gray-300)">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php 
                    $user = Yii::$app->user->identity;
                    if ($user->rol === 'admin' || $user->id === $coleccion->usuarioId): 
                    ?>
                        <?= Html::a('&#9998; Editar Colección', ['update', 'id' => $coleccion->id], [
                            'class' => 'btn btn--outline btn--block'
                        ]) ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?= Html::a('&larr; Volver al listado', ['index'], ['class' => 'btn btn--ghost btn--block']) ?>
            </div>
        </aside>
    </div>
</div>