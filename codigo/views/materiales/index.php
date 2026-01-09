<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\Materia;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Materia[] $mainCategories */
/** @var array $categoryCounts */

$this->title = 'Materiales - Resultados';
$request = Yii::$app->request;

// Recuperar categorías están marcadas
$catsSel = $request->get('category', []);
if (!is_array($catsSel)) $catsSel = [$catsSel];
?>

<div class="container container--wide">

  <div class="page-header">
    <h1 class="page-title">Explorar materiales</h1>
    <p class="page-description">
        Resultados encontrados: <strong><?= $dataProvider->getTotalCount() ?></strong>
    </p>
  </div>
  
  <?= Html::beginForm(['/materiales/index'], 'get', ['class' => 'search-form mb-8']) ?>
    <div class="flex gap-4 flex-wrap">
      <div class="form-group flex-1 min-w-300">
        <label for="search-input" class="visually-hidden">Buscar</label>
        <div class="form-search">
          <span class="form-search__icon">&#128269;</span>
          <input type="search" id="search-input" name="q" class="form-input form-search__input" 
                 placeholder="Buscar por título, autor..." 
                 value="<?= Html::encode($request->get('q')) ?>">
        </div>
      </div>
      <button type="submit" class="btn btn--primary">Buscar</button>
    </div>
  <?= Html::endForm() ?>
  
  <div class="materials-layout">
    
    <aside class="filters-sidebar">
      <h2 class="filters__title">Filtros</h2>
      
      <?= Html::beginForm(['/materiales/index'], 'get') ?>
        <?php if ($q = $request->get('q')): ?>
            <input type="hidden" name="q" value="<?= Html::encode($q) ?>">
        <?php endif; ?>
        
        <div class="filter-group">
          <h3 class="filter-group__title">Categoría</h3>
          <?php if(empty($mainCategories)): ?>
            <p class="text-muted">No hay categorías.</p>
          <?php else: ?>
              <?php foreach ($mainCategories as $cat): ?>
                <?php 
                    $num = $categoryCounts[$cat->id] ?? 0;
                    $isChecked = in_array($cat->id, $catsSel);
                    $icon = '📂'; 
                    if (stripos($cat->nombre, 'Programación') !== false) $icon = '💻';
                    elseif (stripos($cat->nombre, 'Matemáticas') !== false) $icon = '📐';
                    elseif (stripos($cat->nombre, 'Química') !== false) $icon = '🧪';
                    elseif (stripos($cat->nombre, 'Idiomas') !== false) $icon = '🌍';
                    elseif (stripos($cat->nombre, 'Historia') !== false) $icon = '📜';
                    elseif (stripos($cat->nombre, 'Física') !== false) $icon = '⚛️';
                    elseif (stripos($cat->nombre, 'Economía') !== false) $icon = '📊';
                    elseif (stripos($cat->nombre, 'Biología') !== false) $icon = '🧠';
                    elseif (stripos($cat->nombre, 'Artes y Humanidades') !== false) $icon = '🖌️';
                ?>
                <div class="form-checkbox">
                    <input type="checkbox" id="cat-<?= $cat->id ?>" name="category[]" value="<?= $cat->id ?>" <?= $isChecked ? 'checked' : '' ?>>
                    <label for="cat-<?= $cat->id ?>">
                        <?= $icon ?> <?= Html::encode($cat->nombre) ?> 
                        <span class="text-muted small">(<?= $num ?>)</span>
                    </label>
                </div>
              <?php endforeach; ?>
          <?php endif; ?>
        </div>
        
        <div class="filter-group mt-4">
            <h3 class="filter-group__title">Tipo</h3>
            <?php $types = $request->get('type', []); ?>
            <div class="form-checkbox">
                <input type="checkbox" id="type-apuntes" name="type[]" value="apuntes" <?= in_array('apuntes', $types) ? 'checked' : '' ?>>
                <label for="type-apuntes">Apuntes</label>
            </div>
            <div class="form-checkbox">
                <input type="checkbox" id="type-examenes" name="type[]" value="examenes" <?= in_array('examenes', $types) ? 'checked' : '' ?>>
                <label for="type-examenes">Exámenes</label>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn--primary btn--block">Aplicar Filtros</button>
            <a href="<?= Url::to(['/materiales/index']) ?>" class="btn btn--ghost btn--block text-center mt-2" style="display:block">Limpiar</a>
        </div>
      <?= Html::endForm() ?>
    </aside>
    
    <div class="materials-content">
      <div class="grid grid--cols-1 grid--md-cols-2 grid--lg-cols-3">
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <article class="material-card card">
              <div class="card__body">
                <div class="flex justify-between align-center mb-4">
                  <span class="badge <?= ($model->tipo_acceso == 'privado') ? 'badge--secondary' : 'badge--primary' ?>">
                    <?= ($model->tipo_acceso == 'privado') ? 'Examen' : 'Apuntes' ?>
                  </span>
                  <div class="rating">⭐ <?= $model->getRatingPromedio() ?></div>
                </div>
                <h3 class="material-card__title">
                    <a href="<?= Url::to(['materiales/view', 'id' => $model->id]) ?>">
                        <?= Html::encode($model->titulo) ?>
                    </a>
                </h3>
                <p class="material-card__description">Archivo: <em><?= Html::encode($model->archivo_url) ?></em></p>
                <div class="material-card__meta">
                  <span class="material-card__category">
                     📂 <?= $model->materia ? Html::encode($model->materia->nombre) : 'General' ?>
                  </span>
                </div>
              </div>
              <div class="card__footer flex justify-between align-center">
                <span class="material-card__author">👤 <?= $model->autor ? Html::encode($model->autor->nombre) : 'Anónimo' ?></span>
                <span>⬇️ PDF</span>
              </div>
            </article>
        <?php endforeach; ?>
        
        <?php if ($dataProvider->getCount() == 0): ?>
             <div class="alert alert--info p-4 text-center" style="grid-column: 1/-1;">
                No se encontraron resultados.
            </div>
        <?php endif; ?>
      </div>
      
      <div class="mt-8 flex justify-center">
         <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination-custom'], // Clase contenedora UL
            'linkContainerOptions' => ['class' => 'page-item'], // Clases para el LI
            'linkOptions' => ['class' => 'page-link'], // Clases para el enlace A
            'disabledListItemSubTagOptions' => ['class' => 'page-link'],
            
            // Textos bonitos
            'prevPageLabel' => '← Anterior',
            'nextPageLabel' => 'Siguiente →',
            
            // Ocultar primero/último
            'firstPageLabel' => false,
            'lastPageLabel' => false,
            
            // Limitar número de botones
            'maxButtonCount' => 5,
         ]) ?>
      </div>
    </div>
  </div>
</div>

<style>
.pagination-custom {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 20px 0;
    justify-content: center;
    gap: 5px;
}

.pagination-custom .page-item {
    margin: 0;
}

.pagination-custom .page-link {
    display: block;
    padding: 10px 16px;
    color: #4a5568;
    background-color: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    font-weight: 500;
    font-size: 0.95rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.pagination-custom .page-link:hover {
    background-color: #f7fafc;
    border-color: #cbd5e0;
    color: #2d3748;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.pagination-custom .active .page-link {
    background-color: #2563eb; 
    color: white;
    border-color: #2563eb;
    box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
}

.pagination-custom .disabled .page-link {
    color: #a0aec0;
    pointer-events: none;
    background-color: #f7fafc;
    border-color: #edf2f7;
    box-shadow: none;
}
</style>