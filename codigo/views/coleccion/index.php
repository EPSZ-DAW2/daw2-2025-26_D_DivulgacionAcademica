<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Colecciones Académicas';
?>

<main class="main">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
            <p class="page-description">Explora materiales organizados por la comunidad.</p>
        </div>

        <div class="flex justify-between align-center mb-8 flex-wrap gap-4">
            <form action="<?= Url::to(['coleccion/index']) ?>" method="get" class="form-search flex-1 max-w-500">
                <div class="form-search">
                    <span class="form-search__icon">&#128269;</span>
                    <input type="search" name="q" class="form-input form-search__input" placeholder="Buscar colecciones...">
                </div>
            </form>
        </div>

        <div class="grid grid--cols-1 grid--md-cols-2 grid--lg-cols-3">
            <?php foreach ($colecciones as $col): ?>
                <article class="collection-card card">
                    <div class="card__header">
                        <div class="flex justify-between mb-3">
                            <span class="badge badge--success">Pública</span>
                            <span class="badge badge--secondary"><?= count($col->documentos) ?> materiales</span>
                        </div>
                        <h3 class="collection-card__title">
                            <?= Html::a(Html::encode($col->titulo), ['view', 'id' => $col->id]) ?>
                        </h3>
                        <p class="collection-card__description"><?= Html::encode($col->descripcion) ?></p>
                    </div>
                    
                    <div class="card__footer flex justify-between align-center">
                        <span class="material-card__author">
                            &#128100; <strong><?= Html::encode($col->usuario->nombre) ?></strong>
                        </span>
    
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'alumno'): ?>
                            <?php if ($col->estaUnido(Yii::$app->user->id)): ?>
                                <span class="badge badge--success">✓ Unido</span>
                            <?php else: ?>
                                <?= Html::a('Unirme', ['unirse', 'id' => $col->id], [
                                    'class' => 'btn btn--primary btn--sm',
                                    'data-method' => 'post'
                                ]) ?>
                            <?php endif; ?>
                        <?php endif; ?>
                </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>