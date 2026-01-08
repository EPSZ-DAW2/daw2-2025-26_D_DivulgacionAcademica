<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Colecciones Académicas - Portal Académico';
?>

<main id="main-content" class="main" role="main">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Colecciones temáticas</h1>
            <p class="page-description">Descubre colecciones de materiales cuidadosamente organizados por tema o asignatura</p>
        </div>
      
        <div class="flex justify-between align-center mb-8 flex-wrap gap-4">
            <form action="<?= Url::to(['coleccion/index']) ?>" method="get" class="form-search flex-1 max-w-500">
                <div class="form-search">
                    <span class="form-search__icon" aria-hidden="true">&#128269;</span>
                    <input type="search" name="q" class="form-input form-search__input" placeholder="Buscar colecciones...">
                </div>
            </form>
            <div class="alert alert--info m-0">
                <p class="mb-0">
                    <a href="<?= Url::to(['site/login']) ?>" style="font-weight: var(--font-weight-semibold);">Inicia sesión</a> 
                    como colaborador para crear tus propias colecciones
                </p>
            </div>
        </div>

        <div class="grid grid--cols-1 grid--md-cols-2 grid--lg-cols-3">
            <?php foreach ($colecciones as $col): ?>
                <article class="collection-card card">
                    <div class="card__header collection-card__header">
                        <div class="flex justify-between align-center mb-3">
                            <span class="badge badge--success">Pública</span>
                            <span class="badge badge--secondary">Dato DB</span>
                        </div>
                        
                        <h3 class="collection-card__title">
                            <a href="<?= Url::to(['coleccion/view', 'id' => $col->id]) ?>">
                                <?= Html::encode($col->titulo) ?>
                            </a>
                        </h3>
                        
                        <p class="collection-card__description">
                            <?= Html::encode($col->descripcion) ?>
                        </p>
                    </div>
                    
                    <div class="card__footer">
                        <div class="collection-card__meta">
                            <span>&#128100; Por <strong><?= Html::encode($col->usuario->nombre) ?></strong></span>
                            <span>&#11015;&#65039; <?= $col->descargas ?> descargas</span>
                            <span>&#128197; <?= Yii::$app->formatter->asRelativeTime($col->fecha_actualizacion) ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>