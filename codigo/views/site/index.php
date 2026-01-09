<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Documento[] $recientes */
/** @var array $stats */

$this->title = 'Portal Académico - Inicio';
?>

<div class="site-index">

    <section class="hero" aria-labelledby="hero-title">
      <div class="container">
        <div class="hero__content">
          <h1 id="hero-title" class="hero__title text-center">
            Comparte y descubre material académico
          </h1>
          <p class="hero__subtitle text-center">
            Miles de apuntes, exámenes y recursos educativos compartidos por estudiantes y docentes
          </p>
          
          <?= Html::beginForm(['/materiales/index'], 'get', ['class' => 'search-form', 'role' => 'search']) ?>
            
            <div class="form-group mb-4">
              <label for="search-input" class="visually-hidden">Buscar materiales</label>
              <div class="form-search">
                <span class="form-search__icon" aria-hidden="true">&#128269;</span>
                <input type="search" id="search-input" name="q" class="form-input form-search__input" placeholder="Buscar por título, tema, autor...">
              </div>
            </div>
            
            <div class="search-form__filters flex flex-wrap gap-4 justify-center">
              
              <div class="form-group mb-0">
                <select name="category[]" class="form-select" style="padding: 10px; border-radius: 4px; border: 1px solid #ddd;">
                  <option value="">Todas las categorías</option>
                  <option value="Programación">Programación (Ciencias Comp.)</option>
                  <option value="Matemáticas">Matemáticas</option>
                  <option value="Física">Física</option>
                  <option value="Química">Química</option>
                  <option value="Biología">Biología</option>
                  <option value="Historia">Historia</option>
                  <option value="Economía">Economía</option>
                  <option value="Idiomas">Idiomas</option>
                  <option value="Arte y Humanidades">Arte y Humanidades</option>
                </select>
              </div>

              <div class="form-group mb-0">
                <select name="access[]" class="form-select" style="padding: 10px; border-radius: 4px; border: 1px solid #ddd;">
                  <option value="">Todos los tipos</option>
                  <option value="publico">Apuntes (Público)</option>
                  <option value="privado">Exámenes (Privado)</option>
                </select>
              </div>
              
              <button type="submit" class="btn btn--primary">Buscar</button>
            </div>
          <?= Html::endForm() ?>
          </div>
      </div>
    </section>
    
    <section class="categories" aria-labelledby="categories-title">
      <div class="container">
        <h2 id="categories-title" class="text-center">Explora por categoría</h2>
        
        <div class="grid grid--cols-1 grid--md-cols-3 gap-4 mt-6">
          
          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Programación']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">💻</div>
                <h3 class="category-card__title">Programación</h3>
              </div>
            </a>
          </article>
          
          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Matemáticas']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">📐</div>
                <h3 class="category-card__title">Matemáticas</h3>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Idiomas']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">🌍</div>
                <h3 class="category-card__title">Idiomas</h3>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Biología']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">🧬</div>
                <h3 class="category-card__title">Biología</h3>
              </div>
            </a>
          </article>
          
          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Física']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">⚛️</div>
                <h3 class="category-card__title">Física</h3>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Química']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">🧪</div>
                <h3 class="category-card__title">Química</h3>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Historia']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">📜</div>
                <h3 class="category-card__title">Historia</h3>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Economía']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">📊</div>
                <h3 class="category-card__title">Economía</h3>
              </div>
            </a>
          </article>
          
          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['/materiales/index', 'category[]' => 'Arte y Humanidades']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">🎨</div>
                <h3 class="category-card__title">Arte y Humanidades</h3>
              </div>
            </a>
          </article>

        </div>
      </div>
    </section>

    <section class="recent-materials mt-8" aria-labelledby="recent-title">
      <div class="container">
        <div class="flex justify-between align-center mb-6">
          <h2 id="recent-title">Últimas subidas</h2>
          <a href="<?= Url::to(['/materiales/index']) ?>" class="btn btn--outline">Ver todos los materiales</a>
        </div>
        
        <div class="grid grid--cols-1 grid--md-cols-2 grid--lg-cols-3">
          <?php foreach ($recientes as $model): ?>
            <article class="material-card card">
                <div class="card__body">
                  <div class="flex justify-between align-center mb-4">
                    <?php 
                        $acceso = $model->tipo_acceso;
                        $badgeText = ($acceso === 'privado') ? 'Examen' : 'Apuntes';
                        $badgeClass = ($acceso === 'privado') ? 'badge--secondary' : 'badge--primary';
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                    <div class="rating">
                      <span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span>
                    </div>
                  </div>
                  
                  <h3 class="material-card__title">
                      <a href="<?= Url::to(['/materiales/index', 'q' => $model->titulo]) ?>">
                          <?= Html::encode($model->titulo) ?>
                      </a>
                  </h3>
                  
                  <p class="material-card__description">
                    Archivo disponible: <em><?= Html::encode($model->archivo_url) ?></em>
                  </p>
                  
                  <div class="material-card__meta">
                    <span class="material-card__category">
                        &#128208; <?= $model->materia ? Html::encode($model->materia->nombre) : 'General' ?>
                    </span>
                  </div>
                </div>
                
                <div class="card__footer flex justify-between align-center">
                  <span class="material-card__author">
                      Por <strong><?= $model->autor ? Html::encode($model->autor->nombre) : 'Usuario' ?></strong>
                  </span>
                  <span class="material-card__downloads">⬇️ PDF</span>
                </div>
            </article>
          <?php endforeach; ?>

          <?php if (empty($recientes)): ?>
            <div class="card p-4" style="grid-column: 1 / -1; text-align: center;">
                <p>No hay documentos recientes. ¡Sé el primero en subir uno!</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="stats mt-8" aria-labelledby="stats-title">
      <div class="container">
        <h2 id="stats-title" class="visually-hidden">Estadísticas</h2>
        <div class="grid grid--cols-2 grid--lg-cols-4">
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: 2rem; font-weight: bold; color: var(--color-primary);"><?= number_format($stats['materiales']) ?></div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Materiales</div>
          </div>
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: 2rem; font-weight: bold; color: var(--color-primary);"><?= number_format($stats['estudiantes']) ?></div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Estudiantes</div>
          </div>
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: 2rem; font-weight: bold; color: var(--color-primary);"><?= number_format($stats['colaboradores']) ?></div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Colaboradores</div>
          </div>
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: 2rem; font-weight: bold; color: var(--color-primary);"><?= number_format($stats['descargas']) ?></div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Descargas</div>
          </div>
        </div>
      </div>
    </section>

</div>