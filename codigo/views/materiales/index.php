<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Materiales Académicos - Portal Académico';
$request = Yii::$app->request;
?>

<div class="container container--wide">

  <div class="page-header">
    <h1 class="page-title">Explorar materiales académicos</h1>
    <p class="page-description">Encuentra apuntes, exámenes y recursos educativos compartidos por la comunidad</p>
  </div>
  
  <form action="<?= Url::to(['index']) ?>" method="get" class="search-form mb-8" role="search">
    <div class="flex gap-4 flex-wrap">
      <div class="form-group flex-1 min-w-300">
        <label for="search-input" class="visually-hidden">Buscar materiales</label>
        <div class="form-search">
          <span class="form-search__icon" aria-hidden="true">&#128269;</span>
          <input 
            type="search" 
            id="search-input" 
            name="q" 
            class="form-input form-search__input" 
            placeholder="Buscar por título, tema, autor..."
            value="<?= Html::encode($request->get('q')) ?>"
          >
        </div>
      </div>
      <button type="submit" class="btn btn--primary">Buscar</button>
    </div>
  </form>
  
  <div class="materials-layout">
    
    <aside class="filters-sidebar" role="complementary">
      <h2 class="filters__title">Filtros</h2>
      
      <form action="<?= Url::to(['index']) ?>" method="get">
        <?php if ($q = $request->get('q')): ?>
            <input type="hidden" name="q" value="<?= Html::encode($q) ?>">
        <?php endif; ?>
        
        <div class="filter-group">
          <h3 class="filter-group__title">Categoría</h3>
          <?php $cats = $request->get('category', []); if(!is_array($cats)) $cats = []; ?>
          
          <div class="form-checkbox">
            <input type="checkbox" id="cat-matematicas" name="category[]" value="Matemáticas" <?= in_array('Matemáticas', $cats) ? 'checked' : '' ?>>
            <label for="cat-matematicas">&#128208; Matemáticas (2,453)</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="cat-programacion" name="category[]" value="Ciencias de la Computación" <?= in_array('Ciencias de la Computación', $cats) ? 'checked' : '' ?>>
            <label for="cat-programacion">&#128187; Programación (1,892)</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="cat-fisica" name="category[]" value="Física" <?= in_array('Física', $cats) ? 'checked' : '' ?>>
            <label for="cat-fisica">&#9883;&#65039; Física (1,567)</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="cat-quimica" name="category[]" value="Química" <?= in_array('Química', $cats) ? 'checked' : '' ?>>
            <label for="cat-quimica">&#129514; Química (1,234)</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="cat-historia" name="category[]" value="Historia" <?= in_array('Historia', $cats) ? 'checked' : '' ?>>
            <label for="cat-historia">&#128220; Historia (987)</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="cat-idiomas" name="category[]" value="Idiomas" <?= in_array('Idiomas', $cats) ? 'checked' : '' ?>>
            <label for="cat-idiomas">&#127757; Idiomas (876)</label>
          </div>
        </div>
        
        <div class="filter-group">
          <h3 class="filter-group__title">Tipo de material</h3>
          <?php $types = $request->get('type', []); if(!is_array($types)) $types = []; ?>
          
          <div class="form-checkbox">
            <input type="checkbox" id="type-apuntes" name="type[]" value="apuntes" <?= in_array('apuntes', $types) ? 'checked' : '' ?>>
            <label for="type-apuntes">Apuntes</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="type-examenes" name="type[]" value="examenes" <?= in_array('examenes', $types) ? 'checked' : '' ?>>
            <label for="type-examenes">Exámenes</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="type-practicas" name="type[]" value="practicas" <?= in_array('practicas', $types) ? 'checked' : '' ?>>
            <label for="type-practicas">Prácticas</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="type-ejercicios" name="type[]" value="ejercicios" <?= in_array('ejercicios', $types) ? 'checked' : '' ?>>
            <label for="type-ejercicios">Ejercicios</label>
          </div>
          <div class="form-checkbox">
            <input type="checkbox" id="type-resumenes" name="type[]" value="resumenes" <?= in_array('resumenes', $types) ? 'checked' : '' ?>>
            <label for="type-resumenes">Resúmenes</label>
          </div>
        </div>
        
        <div class="filter-group">
          <h3 class="filter-group__title">Valoración mínima</h3>
          <?php $rating = $request->get('rating'); ?>
          
          <div class="form-radio">
            <input type="radio" id="rating-4" name="rating" value="4" <?= $rating == '4' ? 'checked' : '' ?>>
            <label for="rating-4">
              <span class="rating">
                <span class="rating__star" aria-hidden="true">&#9733;</span>
                <span class="rating__star" aria-hidden="true">&#9733;</span>
                <span class="rating__star" aria-hidden="true">&#9733;</span>
                <span class="rating__star" aria-hidden="true">&#9733;</span>
                <span class="rating__star rating__star--empty" aria-hidden="true">&#9733;</span>
              </span>
              y más
            </label>
          </div>
          <div class="form-radio">
            <input type="radio" id="rating-3" name="rating" value="3" <?= $rating == '3' ? 'checked' : '' ?>>
            <label for="rating-3">
              <span class="rating">
                <span class="rating__star" aria-hidden="true">&#9733;</span>
                <span class="rating__star" aria-hidden="true">&#9733;</span>
                <span class="rating__star" aria-hidden="true">&#9733;</span>
                <span class="rating__star rating__star--empty" aria-hidden="true">&#9733;</span>
                <span class="rating__star rating__star--empty" aria-hidden="true">&#9733;</span>
              </span>
              y más
            </label>
          </div>
        </div>
        
        <div class="flex gap-4">
          <button type="submit" class="btn btn--primary btn--block">Aplicar filtros</button>
          <a href="<?= Url::to(['index']) ?>" class="btn btn--ghost btn--block text-center" style="display:flex; justify-content:center; align-items:center;">Limpiar</a>
        </div>
      </form>
    </aside>
    
    <div class="materials-content">
      
      <div class="materials-header">
        <p class="results-count">
          Mostrando <strong><?= $dataProvider->getCount() ?></strong> resultados
        </p>
        
        <div class="form-group">
          <label for="sort-select" class="visually-hidden">Ordenar por</label>
          <select id="sort-select" name="sort" class="form-select sort-select" onchange="this.form.submit()">
            <option value="relevance">Más relevantes</option>
            <option value="recent">Más recientes</option>
            <option value="rating">Mejor valorados</option>
          </select>
        </div>
      </div>
      
      <div class="grid grid--cols-1 grid--md-cols-2 grid--lg-cols-3">
        
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <article class="material-card card">
              <div class="card__body">
                <div class="flex justify-between align-center mb-4">
                  <?php 
                    $acceso = $model->tipo_acceso; // 'publico' o 'privado'
                    $badgeText = ($acceso === 'privado') ? 'Examen' : 'Apuntes';
                    $badgeClass = ($acceso === 'privado') ? 'badge--secondary' : 'badge--primary';
                  ?>
                  <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                  
                  <div class="rating">
                    <span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star rating__star--empty">&#9733;</span>
                    <span class="rating__count">(12)</span>
                  </div>
                </div>
                
                <h3 class="material-card__title">
                  <a href="#"><?= Html::encode($model->titulo) ?></a>
                </h3>
                
                <p class="material-card__description">
                   Archivo: <em><?= Html::encode($model->archivo_url) ?></em>
                </p>
                
                <div class="material-card__meta">
                  <span class="material-card__category">
                     <?= $model->materia ? Html::encode($model->materia->nombre) : 'General' ?>
                  </span>
                  <span class="material-card__date">Hace 2 horas</span>
                </div>
              </div>
              
              <div class="card__footer flex justify-between align-center">
                <span class="material-card__author">
                   Por <strong><?= $model->autor ? Html::encode($model->autor->nombre) : 'N/A' ?></strong>
                </span>
                <span class="material-card__downloads">⬇️ PDF</span>
              </div>
            </article>
        <?php endforeach; ?>
        
        <?php if ($dataProvider->getCount() == 0): ?>
            <div class="alert alert--info" style="grid-column: 1 / -1; text-align: center;">
                No se encontraron documentos.
            </div>
        <?php endif; ?>

      </div>
      
      <div class="mt-8 flex justify-center">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination'],
            'linkContainerOptions' => ['class' => 'pagination__item'],
            'linkOptions' => ['class' => 'pagination__link'],
            'disabledListItemSubTagOptions' => ['class' => 'pagination__link', 'style' => 'opacity:0.5; pointer-events:none'],
            'activePageCssClass' => 'active', 
            'prevPageLabel' => '‹',
            'nextPageLabel' => '›',
        ]) ?>
      </div>
      
    </div>
  </div>
</div>