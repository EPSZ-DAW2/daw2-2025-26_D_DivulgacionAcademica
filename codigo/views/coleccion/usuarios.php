<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Usuarios de: ' . $coleccion->titulo;
?>

<div class="container">
    <div class="flex justify-between align-center mb-8">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Volver al Panel', ['index'], ['class' => 'btn btn--ghost']) ?>
    </div>

    <div class="mb-6">
        <input type="text" id="user-search" class="form-control" placeholder="Buscar usuario por nombre...">
    </div>

    <div class="card">
        <div class="card__body">
            <?php if (empty($usuarios)): ?>
                <p class="text-tertiary text-center">No hay usuarios unidos a esta colección.</p>
            <?php else: ?>
                <div class="grid grid--cols-1">
                    <?php foreach ($usuarios as $usuario): ?>
                        <div class="user-item flex justify-between align-center p-4" 
                             style="border-bottom: 1px solid var(--color-gray-200)"
                             data-name="<?= Html::encode(strtolower($usuario->nombre)) ?>">
                            <div>
                                <strong><?= Html::encode($usuario->nombre) ?></strong>
                                <span class="text-tertiary"> (<?= Html::encode($usuario->email) ?>)</span>
                            </div>
                            <div>
                                <?= Html::a('Expulsar', ['abandonar', 'id' => $coleccion->id, 'usuarioId' => $usuario->id], [
                                    'class' => 'btn btn--danger btn--sm',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de expulsar a este usuario de la colección?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="no-user-results" class="p-4 text-center text-tertiary" style="display: none;">
                    No se encontraron usuarios.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// SCRIPT DE BÚSQUEDA DE USUARIOS
$this->registerJs("
    const searchInput = document.getElementById('user-search');
    const items = document.querySelectorAll('.user-item');
    const noResults = document.getElementById('no-user-results');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        let visibleCount = 0;

        items.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            if (name.includes(query)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        noResults.style.display = (visibleCount === 0 && query !== '') ? 'block' : 'none';
    });
");