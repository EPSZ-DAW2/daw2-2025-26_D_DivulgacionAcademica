<?php
use yii\helpers\Url;
use yii\helpers\Html;

/** @var app\models\Coleccion[] $colecciones */
/** @var app\models\Coleccion[] $misColecciones */

$isAlumno = (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'alumno');
$currentUserId = Yii::$app->user->id;
$this->title = 'Explorar Colecciones';
?>

<main class="main" style="background: #fdfdfd; min-height: 100vh; padding-top: 30px;">
    <div class="container-fluid px-12">
        
        <div class="dashboard-container" style="display: flex; gap: 50px; align-items: start;">
            
            <?php if ($isAlumno): ?>
                <aside class="sidebar" style="flex: 0 0 300px; position: sticky; top: 20px;">
                    <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: white;">
                        <div class="p-5" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <h3 style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; gap: 10px;">
                                📚 MIS COLECCIONES (<?= count($misColecciones) ?>)
                            </h3>
                        </div>
                        
                        <div class="p-4 flex flex-column gap-3">
                            <?php if (empty($misColecciones)): ?>
                                <p class="text-tertiary p-4 text-center" style="font-size: 0.8rem;">Aún no tienes colecciones.</p>
                            <?php else: ?>
                                <?php foreach ($misColecciones as $miCol): ?>
                                    <a href="<?= Url::to(['view', 'id' => $miCol->id]) ?>" 
                                       class="flex align-center p-3 border-radius-md hover-primary" 
                                       style="text-decoration: none; color: #475569; background: #fff; border: 1px solid #f1f5f9; transition: all 0.2s; position: relative;">
                                        
                                        <span style="margin-right: 12px; opacity: 0.5;">📁</span>
                                        
                                        <span class="font-weight-semibold" style="font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                                            <?= Html::encode($miCol->titulo) ?>
                                            
                                            <?php if ($miCol->usuarioId === Yii::$app->user->id): ?>
                                                <span title="Colección creada por mí" style="font-size: 0.75rem; color: #f59e0b; filter: drop-shadow(0 0 1px rgba(0,0,0,0.1));">
                                                    ⭐
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="p-4 border-top text-center" style="background: #fafafa;">
                            <?= Html::a('Ir a mi biblioteca completa', ['usuario/view', 'id' => $currentUserId], [
                                'class' => 'text-tertiary', 'style' => 'font-size: 0.65rem; font-weight: 700; text-transform: uppercase; text-decoration: none;'
                            ]) ?>
                        </div>
                    </div>
                </aside>
            <?php endif; ?>

            <div class="main-content" style="flex: 1;">
                <header class="mb-10">
                    <h1 class="page-title" style="color: #1e293b; font-weight: 800; font-size: 2.2rem;"><?= Html::encode($this->title) ?></h1>
                    <p class="page-description" style="font-size: 1.1rem; color: #64748b;">Descubre y crea materiales académicos de calidad.</p>
                </header>

                <div class="mb-12 flex justify-between align-center gap-6">
                    <div class="search-box shadow-sm flex-1" style="border: 1px solid #cbd5e1; border-radius: 50px; background: white; display: flex; align-items: center; position: relative;">
                        <span style="position: absolute; left: 20px; color: #94a3b8; font-size: 1.1rem;">🔍</span>
                        <input type="search" id="collection-search" 
                               placeholder="¿Qué quieres aprender hoy? (ej: python, cálculo, react...)" 
                               style="width: 100%; border: none; padding: 14px 20px 14px 55px; outline: none; font-size: 1rem; border-radius: 50px;">
                    </div>
                    
                    <?php if ($isAlumno): ?>
                        <?= Html::a('+ Crear Colección', ['create'], [
                            'class' => 'btn btn--success',
                            'style' => 'border-radius: 50px; padding: 12px 28px; font-weight: 700; white-space: nowrap; box-shadow: var(--shadow-sm);'
                        ]) ?>
                    <?php endif; ?>
                </div>

                <div class="grid grid--cols-1 grid--md-cols-2 gap-8" id="collections-grid">
                    <?php foreach ($colecciones as $col): ?>
                        <article class="collection-card card h-full flex flex-column shadow-sm" 
                                 data-title="<?= Html::encode(strtolower($col->titulo)) ?>"
                                 style="border-radius: 14px; border: 1px solid #e2e8f0; background: white; overflow: hidden; transition: transform 0.2s;">
                            
                            <div class="card__header flex-1 p-8">
                                <div class="flex justify-between align-center mb-4">
                                    <span class="badge <?= $col->tipo_acceso === 'publico' ? 'badge--success' : 'badge--secondary' ?>" style="font-weight: 700;">
                                        <?= $col->tipo_acceso === 'publico' ? 'Pública' : 'Privada' ?>
                                    </span>
                                    
                                    <div class="text-tertiary" style="font-size: 0.75rem; font-weight: 600; display: flex; gap: 12px;">
                                        <span>📄 <?= count($col->documentos) ?> materiales</span>
                                        <span>👥 <?= count($col->usuarios) ?> usuarios</span>
                                    </div>
                                </div>

                                <h3 class="collection-card__title">
                                    <?= Html::a(Html::encode($col->titulo), ['view', 'id' => $col->id], ['class' => 'text-primary', 'style' => 'text-decoration: none;']) ?>
                                </h3>
                                <p class="mt-4" style="color: #64748b; font-size: 0.9rem; line-height: 1.5;">
                                    <?= Html::encode($col->descripcion) ?>
                                </p>
                            </div>
                            
                            <div class="card__footer flex justify-between align-center p-6" style="background: #f8fafc; border-top: 1px solid #f1f5f9;">
                                <div class="flex align-center gap-3">
                                    <div style="width: 32px; height: 32px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">👤</div>
                                    <div class="flex flex-column">
                                        <span style="font-size: 0.6rem; text-transform: uppercase; color: #94a3b8; font-weight: 800;">Autor</span>
                                        <strong style="font-size: 0.8rem; color: #475569;"><?= Html::encode($col->usuario->nombre) ?></strong>
                                    </div>
                                </div>
            
                                <?php if ($isAlumno): ?>
                                    <div class="flex align-center gap-2">
                                        <?php if ($col->usuarioId === $currentUserId): ?>
                                            <?= Html::a('📝', ['update', 'id' => $col->id], ['class' => 'btn btn--ghost btn--sm', 'title' => 'Editar']) ?>
                                            <?= Html::a('🗑️', ['delete', 'id' => $col->id], [
                                                'class' => 'btn btn--ghost btn--sm',
                                                'style' => 'color: #ef4444; border: 1px solid #ef4444;',
                                                'data-confirm' => '¿Estás seguro de que quieres borrar tu colección?',
                                                'data-method' => 'post',
                                                'title' => 'Eliminar'
                                            ]) ?>
                                        <?php elseif ($col->estaUnido($currentUserId)): ?>
                                            <span class="badge badge--success" style="padding: 8px 16px;">✓ Unido</span>
                                            <?= Html::a('Abandonar', ['abandonar', 'id' => $col->id], [
                                                'class' => 'btn btn--ghost btn--sm',
                                                'style' => 'color: #ef4444; border: 1px solid #ef4444; border-radius: 8px;',
                                                'data-confirm' => '¿Quieres dejar de seguir esta colección?',
                                                'data-method' => 'post',
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a('Unirme', ['unirse', 'id' => $col->id], [
                                                'class' => 'btn btn--primary btn--sm',
                                                'data-method' => 'post',
                                                'style' => 'font-weight: 700; border-radius: 8px; padding: 8px 20px;'
                                            ]) ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div id="no-results" class="alert alert--info p-12 text-center mt-10" style="display: none; border-radius: 12px; border: 2px dashed #cbd5e1; background: #f8fafc;">
                    <p style="font-size: 1.1rem; color: #64748b; margin: 0;">No se han encontrado colecciones con ese nombre.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Script de búsqueda corregido: usa display 'flex' para no romper el diseño
$this->registerJs("
    const searchInput = document.getElementById('collection-search');
    const cards = document.querySelectorAll('.collection-card');
    const noResults = document.getElementById('no-results');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        let visibleCount = 0;

        cards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            if (title.includes(query)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = (visibleCount === 0 && query !== '') ? 'block' : 'none';
    });
");
?>