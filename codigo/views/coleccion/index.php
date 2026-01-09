<?php
use yii\helpers\Url;
use yii\helpers\Html;

$isAlumno = (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'alumno');
$this->title = 'Explorar Colecciones';
?>

<main class="main" style="background: #fdfdfd; min-height: 100vh; padding-top: 30px;">
    <div class="container-fluid px-12">
        
        <div class="dashboard-container" style="display: flex; gap: 50px; align-items: start;">
            
            <?php if ($isAlumno): ?>
                <aside class="sidebar" style="flex: 0 0 320px; position: sticky; top: 20px;">
                    <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: white;">
                        <div class="p-5" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <h3 style="font-size: 0.8rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; gap: 10px;">
                                📚 MIS COLECCIONES (<?= count($misColecciones) ?>)
                            </h3>
                        </div>
                        
                        <div class="p-4 flex flex-column gap-3">
                            <?php if (empty($misColecciones)): ?>
                                <p class="text-tertiary p-4 text-center" style="font-size: 0.8rem;">Aún no sigues ninguna colección.</p>
                            <?php else: ?>
                                <?php foreach ($misColecciones as $miCol): ?>
                                    <a href="<?= Url::to(['view', 'id' => $miCol->id]) ?>" 
                                       class="flex align-center p-3 border-radius-md hover-primary" 
                                       style="text-decoration: none; color: #475569; background: #fff; border: 1px solid #f1f5f9; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                        <span style="margin-right: 12px; opacity: 0.5;">📁</span>
                                        <span class="font-weight-semibold" style="font-size: 0.9rem;"><?= Html::encode($miCol->titulo) ?></span>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="p-4 border-top text-center" style="background: #fafafa;">
                            <?= Html::a('Ir a mi biblioteca completa', ['usuario/view', 'id' => Yii::$app->user->id], [
                                'class' => 'text-tertiary', 'style' => 'font-size: 0.7rem; font-weight: 600; text-transform: uppercase;'
                            ]) ?>
                        </div>
                    </div>
                </aside>
            <?php endif; ?>

            <div class="main-content" style="flex: 1;">
                <header class="mb-10">
                    <h1 class="page-title" style="color: #1e293b; font-weight: 800; font-size: 2.5rem;"><?= Html::encode($this->title) ?></h1>
                    <p class="page-description" style="font-size: 1.1rem; color: #64748b;">Encuentra materiales académicos organizados por la comunidad.</p>
                </header>

                <div class="mb-12" style="max-width: 800px;">
                    <div class="search-box shadow-sm" style="border: 2px solid #e2e8f0; border-radius: 50px; background: white; display: flex; align-items: center; position: relative;">
                        <span style="position: absolute; left: 20px; color: #94a3b8; font-size: 1.2rem;">🔍</span>
                        <input type="search" id="collection-search" 
                               placeholder="¿Qué quieres aprender hoy? (ej: frontend, php, redes...)" 
                               style="width: 100%; border: none; padding: 16px 20px 16px 55px; outline: none; font-size: 1.05rem; border-radius: 50px;">
                    </div>
                </div>

                <div class="grid grid--cols-1 grid--md-cols-2 gap-10" id="collections-grid">
                    <?php foreach ($colecciones as $col): ?>
                        <article class="collection-card card h-full flex flex-column shadow-sm" 
                                 data-title="<?= Html::encode(strtolower($col->titulo)) ?>"
                                 style="border-radius: 16px; border: 1px solid #e2e8f0; background: white; overflow: hidden; transition: transform 0.2s ease;">
                            
                            <div class="card__header flex-1 p-8">
                                <div class="flex justify-between align-center mb-5">
                                    <span class="badge badge--success" style="padding: 4px 12px; border-radius: 6px; font-weight: 700;">Pública</span>
                                    <span class="text-tertiary" style="font-size: 0.8rem; font-weight: 600;"><?= count($col->documentos) ?> materiales</span>
                                </div>
                                <h3 class="collection-card__title" style="font-size: 1.35rem; color: #1e293b; line-height: 1.4;">
                                    <?= Html::a(Html::encode($col->titulo), ['view', 'id' => $col->id], ['class' => 'text-primary', 'style' => 'text-decoration: none;']) ?>
                                </h3>
                                <p class="mt-4" style="color: #64748b; font-size: 0.95rem; line-height: 1.6;">
                                    <?= Html::encode($col->descripcion) ?>
                                </p>
                            </div>
                            
                            <div class="card__footer flex justify-between align-center p-6" style="background: #f8fafc; border-top: 1px solid #f1f5f9;">
                                <div class="flex align-center gap-3">
                                    <div style="width: 32px; height: 32px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">👤</div>
                                    <div class="flex flex-column">
                                        <span style="font-size: 0.65rem; text-transform: uppercase; color: #94a3b8; font-weight: bold;">Autor</span>
                                        <strong style="font-size: 0.85rem; color: #475569;"><?= Html::encode($col->usuario->nombre) ?></strong>
                                    </div>
                                </div>
            
                                <?php if ($isAlumno): ?>
                                    <?php if ($col->estaUnido(Yii::$app->user->id)): ?>
                                        <span class="badge badge--success" style="padding: 10px 20px; font-weight: 700;">✓ Unido</span>
                                    <?php else: ?>
                                        <?= Html::a('Unirme', ['unirse', 'id' => $col->id], [
                                            'class' => 'btn btn--primary',
                                            'data-method' => 'post',
                                            'style' => 'border-radius: 8px; font-weight: 700; padding: 10px 24px;'
                                        ]) ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div id="no-results" class="alert alert--info p-12 text-center mt-10" style="display: none; border-radius: 12px; border: 2px dashed #e2e8f0; background: #f8fafc;">
                    <p style="font-size: 1.1rem; color: #64748b; margin: 0;">No se encontraron colecciones con ese nombre.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// SCRIPT DE BÚSQUEDA: Corregido para esta nueva estructura
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
                card.style.display = 'flex'; // Importante usar 'flex' para no romper el diseño interno
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = (visibleCount === 0 && query !== '') ? 'block' : 'none';
    });
");
?>