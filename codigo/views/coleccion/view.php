<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Coleccion $coleccion */
/** @var app\models\Documento|null $selectedDoc */

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
            <?= Html::a('&#11015;&#65039; Descargar PDF', ['download', 'id' => $coleccion->id], ['class' => 'btn btn--white', 'style' => 'color: var(--color-primary); font-weight: bold;']) ?>
        </div>
    </header>

    <div class="grid grid--cols-1 grid--lg-cols-3 gap-8">
        <div class="grid--lg-cols-1 flex-column gap-6">
            <h2 class="section-title mb-6">Materiales incluidos</h2>
            <div class="grid grid--cols-1 gap-4">
                <?php foreach ($coleccion->documentos as $doc): ?>
                    <article class="card <?= ($selectedDoc && $selectedDoc->id == $doc->id) ? 'border-primary' : '' ?>">
                        <div class="card__body">
                            <div class="flex justify-between mb-4">
                                <span class="badge badge--primary"><?= strtoupper($doc->tipo_acceso) ?></span>
                                <span class="text-tertiary" style="font-size: var(--font-size-xs)">Ref: #<?= $doc->id ?></span>
                            </div>
                            <h3 class="material-card__title" style="font-size: var(--font-size-md)"><?= Html::encode($doc->titulo) ?></h3>
                        </div>
                        <div class="card__footer bg-secondary">
                            <?= Html::a('Ver Material', ['view', 'id' => $coleccion->id, 'docId' => $doc->id], ['class' => 'btn btn--ghost btn--sm btn--block']) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="grid--lg-cols-2">
            <div class="card h-full" style="min-height: 600px;">
                <div class="card__header border-bottom bg-secondary flex justify-between align-center">
                    <h3 class="card__title mt-0 mb-0">
                        <?= $selectedDoc ? 'Vista Previa: ' . Html::encode($selectedDoc->titulo) : 'Sobre esta colección' ?>
                    </h3>
                    <?php if ($selectedDoc): ?>
                        <?= Html::a('&#10005;', ['view', 'id' => $coleccion->id], ['class' => 'text-tertiary', 'title' => 'Cerrar vista previa']) ?>
                    <?php endif; ?>
                </div>
                
                <div class="card__body p-8">
                    <?php if ($selectedDoc): ?>
                        <div class="visor-container mb-6" style="background: #525659; padding: 20px; border-radius: var(--border-radius-md);">
                            <div style="background: white; padding: 40px; box-shadow: var(--shadow-md); min-height: 400px; position: relative;">
                                <h4 class="text-center mb-6" style="border-bottom: 1px solid #eee; padding-bottom: 10px;"><?= Html::encode($selectedDoc->titulo) ?></h4>
                                <div style="filter: blur(3px); opacity: 0.4; pointer-events: none;">
                                    <p>Contenido académico de la materia <?= Html::encode($selectedDoc->materia->nombre) ?>. Este documento ha sido emitido por <?= Html::encode($selectedDoc->institucion->nombre) ?>...</p>
                                    <div style="background: #f0f0f0; height: 10px; width: 80%; margin-bottom: 10px;"></div>
                                    <div style="background: #f0f0f0; height: 10px; width: 90%; margin-bottom: 10px;"></div>
                                    <div style="background: #f0f0f0; height: 10px; width: 70%;"></div>
                                </div>
                                <div class="flex justify-center" style="position: absolute; bottom: 40px; left: 0; right: 0;">
                                    <span class="badge badge--primary">Modo lectura rápida</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between align-center p-4 bg-secondary border-radius-md">
                            <div>
                                <p class="mb-0"><strong>Autor:</strong> <?= Html::encode($selectedDoc->autor->nombre) ?></p>
                                <p class="text-tertiary mb-0" style="font-size: var(--font-size-sm)">Formato: PDF Original</p>
                            </div>
                            <?= Html::a('&#11015;&#65039; Descargar Material', ['documento/download', 'id' => $selectedDoc->id], ['class' => 'btn btn--primary']) ?>
                        </div>

                    <?php else: ?>
                        <p class="material-description" style="font-size: var(--font-size-lg); line-height: 1.8;">
                            <?= nl2br(Html::encode($coleccion->descripcion)) ?>
                        </p>
                        <div class="mt-12 p-8 text-center border-radius-md" style="border: 2px dashed var(--color-gray-200);">
                            <p class="text-secondary">Selecciona un material de la izquierda para previsualizarlo aquí mismo.</p>
                        </div>
                        <div class="mt-8">
                            <?= Html::a('&larr; Volver al listado', ['index'], ['class' => 'btn btn--ghost']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>