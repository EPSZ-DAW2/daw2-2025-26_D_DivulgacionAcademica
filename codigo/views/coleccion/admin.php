<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $esAdmin ? 'Panel Super Admin: Todas las Colecciones' : 'Mis Colecciones (Gestor)';
?>

<div class="container">
    <div class="flex justify-between align-center mb-8">
        <div>
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
            <?php if ($esAdmin): ?>
                <span class="badge badge--primary">Modo Control Total</span>
            <?php endif; ?>
        </div>
        <?= Html::a('+ Crear Nueva Colección', ['create'], ['class' => 'btn btn--success']) ?>
    </div>

    <div class="mb-6">
        <input type="text" id="admin-search" class="form-control" placeholder="Buscar colección...">
    </div>

    <div class="card">
        <div class="card__body">
            <div class="grid grid--cols-1" id="admin-collections-list">
                <?php foreach ($colecciones as $col): ?>
                    <div class="collection-item flex justify-between align-center p-4" 
                         style="border-bottom: 1px solid var(--color-gray-200)"
                         data-title="<?= Html::encode(strtolower($col->titulo)) ?>">
                        <div class="flex-1">
                            <h3 class="mb-0"><?= Html::encode($col->titulo) ?></h3>
                            <p class="text-tertiary mb-0" style="font-size: var(--font-size-sm)">
                                <strong>Autor:</strong> <?= Html::encode($col->usuario->nombre) ?> 
                                (<?= Html::encode($col->usuario->rol) ?>) </p>
                        </div>
                        
                        <div class="flex gap-4">
                            <?= Html::a('Ver contenido', ['view', 'id' => $col->id], ['class' => 'btn btn--ghost btn--sm']) ?>
                            
                            <?php if ($esAdmin): ?>
                                <?= Html::a('Ver usuarios', ['usuarios', 'id' => $col->id], ['class' => 'btn btn--ghost btn--sm']) ?>
                            <?php endif; ?>
                            
                            <?= Html::a('Editar', ['update', 'id' => $col->id], ['class' => 'btn btn--outline btn--sm']) ?>
                            
                            <?= Html::a('Eliminar', ['delete', 'id' => $col->id], [
                                'class' => 'btn btn--danger btn--sm',
                                'data' => [
                                    'confirm' => '¿Estás seguro de eliminar esta colección? Esta acción no se puede deshacer.',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div id="no-results" class="p-4 text-center text-tertiary" style="display: none;">
                    No se encontraron colecciones.
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// SCRIPT DE BÚSQUEDA EN TIEMPO REAL
$this->registerJs("
    const searchInput = document.getElementById('admin-search');
    const items = document.querySelectorAll('.collection-item');
    const noResults = document.getElementById('no-results');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        let visibleCount = 0;

        items.forEach(item => {
            const title = item.getAttribute('data-title') || '';
            if (title.includes(query)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        noResults.style.display = (visibleCount === 0 && query !== '') ? 'block' : 'none';
    });
");
?>