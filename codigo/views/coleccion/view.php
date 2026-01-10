<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Coleccion $coleccion */
/** @var app\models\Documento|null $selectedDoc */

$this->title = $coleccion->titulo;
$isGuest = Yii::$app->user->isGuest; // Detectamos si es invitado
$isOwner = (!$isGuest && $coleccion->usuarioId === Yii::$app->user->id);

$getIcon = function($url) {
    $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
    $icons = ['pdf' => '📄', 'doc' => '📝', 'docx' => '📝', 'xls' => '📊', 'xlsx' => '📊', 'mp4' => '🎥'];
    return $icons[$ext] ?? '📁';
};
?>

<div class="container py-8" style="max-width: 1200px; margin: 0 auto; background: #fdfdfd; min-height: 90vh;">
    
    <header class="flex justify-between align-end mb-10 border-bottom pb-6">
        <div>
            <div class="flex align-center gap-3 mb-2">
                <h1 class="page-title mb-0" style="font-size: 1.8rem; color: #1e293b;"><?= Html::encode($this->title) ?></h1>
                <span class="badge <?= $coleccion->tipo_acceso === 'publico' ? 'badge--success' : 'badge--secondary' ?>" style="font-size: 0.7rem;">
                    <?= strtoupper($coleccion->tipo_acceso) ?>
                </span>
            </div>
            <p class="text-tertiary mb-0" style="font-size: 0.95rem;">
                👤 Creado por <strong><?= Html::encode($coleccion->usuario->nombre) ?></strong> 
                • <?= count($coleccion->documentos) ?> materiales
            </p>
            <div class="collection-detail__meta">
                    <span>&#128197; Actualizada: <?= Yii::$app->formatter->asDate($coleccion->fecha_actualizacion) ?></span>
                    <span>&#11015;&#65039; <?= $coleccion->descargas ?> descargas</span>
                </div>   
        
        </div>
        <div class="flex align-center gap-4">
            <?php if ($isGuest): ?>
                <span class="text-tertiary" style="font-size: 0.8rem; font-style: italic;">
                    🔒 <?= Html::a('Inicia sesión', ['site/login'], ['style' => 'color: var(--color-primary); font-weight: 700;']) ?> para descargar PDF
                </span>
            <?php else: ?>
                <?= Html::a('Descargar PDF', ['download', 'id' => $coleccion->id], ['class' => 'btn btn--ghost btn--sm', 'style' => 'border: 1px solid #e2e8f0;']) ?>
            <?php endif; ?>
            
            <?= Html::a('&larr; Volver', ['index'], ['class' => 'btn btn--ghost btn--sm']) ?>
        </div>
    </header>

    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 30px; align-items: start;">
        
        <aside style="max-height: 70vh; overflow-y: auto; padding-right: 10px;">
            <h3 class="mb-5" style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.2px; font-weight: 800;">
                CONTENIDO
            </h3>
            
            <div class="flex flex-column gap-3">
                <?php foreach ($coleccion->documentos as $doc): ?>
                    <article class="card <?= ($selectedDoc && $selectedDoc->id == $doc->id) ? 'border-primary shadow-sm' : '' ?>" style="border-radius: 10px;">
                        <div class="card__body p-4">
                            <div class="flex justify-between align-center mb-2">
                                <span class="badge badge--primary" style="font-size: 0.6rem; padding: 2px 6px;">
                                    <?= strtoupper($doc->tipo_acceso) ?>
                                </span>
                                <?php if ($isOwner): ?>
                                    <?= Html::a('✕', ['quitar-material', 'id' => $coleccion->id, 'docId' => $doc->id], [
                                        'class' => 'text-tertiary hover-primary',
                                        'style' => 'text-decoration: none; font-size: 0.9rem;',
                                        'data-confirm' => '¿Quitar de la colección?',
                                        'data-method' => 'post',
                                    ]) ?>
                                <?php endif; ?>
                            </div>
                            <h4 style="font-size: 0.85rem; color: #334155; line-height: 1.3; margin-bottom: 12px; font-weight: 600;">
                                <?= $getIcon($doc->archivo_url) ?> <?= Html::encode($doc->titulo) ?>
                            </h4>
                            <?= Html::a('Ver material', ['view', 'id' => $coleccion->id, 'docId' => $doc->id], [
                                'class' => 'btn btn--ghost btn--sm btn--block',
                                'style' => ($selectedDoc && $selectedDoc->id == $doc->id) 
                                    ? 'background: var(--color-primary); color: white; border: none; font-size: 0.75rem;' 
                                    : 'background: #f8fafc; font-size: 0.75rem;'
                            ]) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </aside>

        <section class="card shadow-sm flex flex-column" style="border-radius: 12px; background: white; border: 1px solid #e2e8f0; max-width: 800px;">
            <?php if ($selectedDoc): ?>
                <div class="p-5 bg-secondary border-bottom flex justify-between align-center" style="border-radius: 12px 12px 0 0; background: #f8fafc;">
                    <h3 class="mb-0" style="font-size: 1.1rem; color: #1e293b; font-weight: 700;">
                        Vista Previa: <?= Html::encode($selectedDoc->titulo) ?>
                    </h3>
                    <?= Html::a('✕', ['view', 'id' => $coleccion->id], ['style' => 'text-decoration: none; color: #94a3b8; font-weight: bold;']) ?>
                </div>
                <div class="p-10 text-center">
                    <div style="font-size: 4rem; margin-bottom: 20px;">📄</div>
                    <h2 style="font-size: 1.5rem; color: #1e293b;"><?= Html::encode($selectedDoc->titulo) ?></h2>
                    <p class="text-tertiary mb-8">Documento listo para consulta académica.</p>
                    
                    <?php if ($isGuest): ?>
                        <div class="p-8" style="background: #f1f5f9; border: 2px dashed #cbd5e1; border-radius: 12px; max-width: 400px; margin: 0 auto;">
                            <p class="mb-5" style="color: #475569; font-size: 0.95rem;">
                                Para descargar este archivo y guardarlo en tu biblioteca, debes estar identificado.
                            </p>
                            <?= Html::a('🔐 Iniciar Sesión para Descargar', ['site/login'], ['class' => 'btn btn--primary px-8', 'style' => 'font-weight: 700;']) ?>
                        </div>
                    <?php else: ?>
                        <?= Html::a('Descargar Archivo', ['documento/download', 'id' => $selectedDoc->id], ['class' => 'btn btn--primary px-8']) ?>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="p-10 border-bottom" style="background: #f9fbff; border-radius: 12px 12px 0 0; text-align: center;">
                    <h3 class="mb-0" style="font-size: 0.85rem; color: #3b82f6; text-transform: uppercase; letter-spacing: 2px; font-weight: 900;">
                        Información de la colección
                    </h3>
                </div>
                
                <div class="p-12 flex-1 flex flex-column align-center">
                    <div class="description-container mb-12" style="text-align: center; max-width: 600px;">
                        <p style="font-size: 1.25rem; color: #475569; line-height: 1.7; font-weight: 400; margin: 0;">
                            <?= nl2br(Html::encode($coleccion->descripcion)) ?>
                        </p>
                    </div>
                    
                    <div class="p-10 text-center" style="border: 1px dashed #e2e8f0; background: #ffffff; border-radius: 16px; width: 100%; max-width: 450px;">
                        <p class="text-tertiary mb-0" style="font-size: 0.95rem; font-style: italic;">
                            Selecciona un material de la izquierda para previsualizarlo aquí.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>