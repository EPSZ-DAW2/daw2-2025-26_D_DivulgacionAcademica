<?php
use yii\helpers\Url;

/** @var yii\web\View $this */
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
          
          <form action="<?= Url::to(['documento/index']) ?>" method="get" class="search-form" role="search">
            <div class="form-group">
              <label for="search-input" class="visually-hidden">Buscar materiales</label>
              <div class="form-search">
                <span class="form-search__icon" aria-hidden="true">&#128269;</span>
                <input type="search" id="search-input" name="q" class="form-input form-search__input" placeholder="Buscar apuntes, exámenes, prácticas...">
              </div>
            </div>
            
            <div class="search-form__filters flex flex-wrap gap-4 justify-center">
              
              <div class="form-group mb-0">
                <select name="category" class="form-select">
                  <option value="">Todas las categorías</option>
                  <option value="matematicas">Matemáticas</option>
                  <option value="fisica">Física</option>
                  <option value="programacion">Programación</option>
                  <option value="quimica">Química</option>
                  <option value="historia">Historia</option>
                </select>
              </div>

              <div class="form-group mb-0">
                <select name="type" class="form-select">
                  <option value="">Todos los tipos</option>
                  <option value="apuntes">Apuntes</option>
                  <option value="examenes">Exámenes</option>
                  <option value="practicas">Prácticas</option>
                  <option value="resumenes">Resúmenes</option>
                </select>
              </div>
              
              <button type="submit" class="btn btn--primary">Buscar</button>
            </div>
          </form>
        </div>
      </div>
    </section>
    
    <section class="categories" aria-labelledby="categories-title">
      <div class="container">
        <h2 id="categories-title" class="text-center">Explora por categoría</h2>
        
        <div class="grid grid--cols-2 grid--md-cols-3 grid--lg-cols-4 mt-6">
          
          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index', 'cat' => 'matematicas']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#128208;</div>
                <h3 class="category-card__title">Matemáticas</h3>
                <p class="category-card__count">2,453 materiales</p>
              </div>
            </a>
          </article>
          
          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index', 'cat' => 'programacion']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#128187;</div>
                <h3 class="category-card__title">Programación</h3>
                <p class="category-card__count">1,892 materiales</p>
              </div>
            </a>
          </article>
          
          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index', 'cat' => 'fisica']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#9883;&#65039;</div>
                <h3 class="category-card__title">Física</h3>
                <p class="category-card__count">1,567 materiales</p>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index', 'cat' => 'quimica']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#129514;</div>
                <h3 class="category-card__title">Química</h3>
                <p class="category-card__count">1,234 materiales</p>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index', 'cat' => 'historia']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#128220;</div>
                <h3 class="category-card__title">Historia</h3>
                <p class="category-card__count">987 materiales</p>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index', 'cat' => 'idiomas']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#127757;</div>
                <h3 class="category-card__title">Idiomas</h3>
                <p class="category-card__count">876 materiales</p>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index', 'cat' => 'economia']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#128202;</div>
                <h3 class="category-card__title">Economía</h3>
                <p class="category-card__count">654 materiales</p>
              </div>
            </a>
          </article>

          <article class="category-card card card--clickable">
            <a href="<?= Url::to(['documento/index']) ?>" class="category-card__link">
              <div class="card__body text-center">
                <div class="category-card__icon" aria-hidden="true">&#10133;</div>
                <h3 class="category-card__title">Ver todas</h3>
                <p class="category-card__count">15+ categorías</p>
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
          <a href="<?= Url::to(['documento/index']) ?>" class="btn btn--outline">Ver todos los materiales</a>
        </div>
        
        <div class="grid grid--cols-1 grid--md-cols-2 grid--lg-cols-3">
          <article class="material-card card">
            <div class="card__body">
              <div class="flex justify-between align-center mb-4">
                <span class="badge badge--primary">Apuntes</span>
                <div class="rating">
                  <span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span>
                  <span class="rating__count">(127)</span>
                </div>
              </div>
              <h3 class="material-card__title"><a href="#">Cálculo Diferencial e Integral</a></h3>
              <p class="material-card__description">Apuntes completos de Cálculo I incluyendo límites, derivadas e integrales.</p>
              <div class="material-card__meta">
                <span class="material-card__category">&#128208; Matemáticas</span>
                <span class="material-card__date">Hace 2 horas</span>
              </div>
            </div>
            <div class="card__footer flex justify-between align-center">
              <span class="material-card__author">Por <strong>María García</strong></span>
              <span class="material-card__downloads">1.2K descargas</span>
            </div>
          </article>
          
          <article class="material-card card">
            <div class="card__body">
              <div class="flex justify-between align-center mb-4">
                <span class="badge badge--secondary">Examen</span>
                <div class="rating">
                  <span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span>
                </div>
              </div>
              <h3 class="material-card__title"><a href="#">Examen Resuelto - POO Java</a></h3>
              <p class="material-card__description">Examen de febrero 2024 con soluciones detalladas.</p>
              <div class="material-card__meta">
                <span class="material-card__category">&#128187; Programación</span>
                <span class="material-card__date">Hace 5 horas</span>
              </div>
            </div>
            <div class="card__footer flex justify-between align-center">
              <span class="material-card__author">Por <strong>Carlos Ruiz</strong></span>
              <span class="material-card__downloads">856 descargas</span>
            </div>
          </article>
          
          <article class="material-card card">
            <div class="card__body">
              <div class="flex justify-between align-center mb-4">
                <span class="badge badge--primary">Apuntes</span>
                <div class="rating">
                  <span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span><span class="rating__star">&#9733;</span>
                </div>
              </div>
              <h3 class="material-card__title"><a href="#">Física Cuántica - Resumen</a></h3>
              <p class="material-card__description">Resumen esquemático con diagramas y explicaciones claras.</p>
              <div class="material-card__meta">
                <span class="material-card__category">&#9883;&#65039; Física</span>
                <span class="material-card__date">Hace 1 día</span>
              </div>
            </div>
            <div class="card__footer flex justify-between align-center">
              <span class="material-card__author">Por <strong>Ana Martínez</strong></span>
              <span class="material-card__downloads">543 descargas</span>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="cta mt-8" aria-labelledby="cta-title">
      <div class="container">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
          <div class="card__body text-center" style="padding: var(--spacing-10);">
            <h2 id="cta-title" style="color: var(--color-text-inverse); font-size: var(--font-size-3xl);">
              ¿Quieres colaborar?
            </h2>
            <p style="color: var(--color-text-inverse); font-size: var(--font-size-lg); margin-bottom: var(--spacing-6);">
              Conviértete en colaborador y comparte tus apuntes con miles de estudiantes
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
              <a href="<?= Url::to(['site/register']) ?>" class="btn btn--lg" style="background-color: white; color: #667eea;">
                Registrarse gratis
              </a>
              <a href="#" class="btn btn--lg btn--outline" style="border-color: white; color: white;">
                Subir material
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="stats mt-8" aria-labelledby="stats-title">
      <div class="container">
        <h2 id="stats-title" class="visually-hidden">Estadísticas de la plataforma</h2>
        
        <div class="grid grid--cols-2 grid--lg-cols-4">
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-primary);">12,456</div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Materiales compartidos</div>
          </div>
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-primary);">8,943</div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Estudiantes activos</div>
          </div>
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-primary);">2,341</div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Colaboradores</div>
          </div>
          <div class="stat-card text-center">
            <div class="stat-card__value" style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-primary);">156K</div>
            <div class="stat-card__label" style="color: var(--color-text-secondary);">Descargas totales</div>
          </div>
        </div>
      </div>
    </section>

</div>