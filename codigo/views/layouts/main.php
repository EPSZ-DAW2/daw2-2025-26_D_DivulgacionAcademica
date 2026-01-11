<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

// Registrr estilos
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

  <header class="header" role="banner">
    <div class="header__container">
      <a href="<?= Url::home() ?>" class="header__logo" aria-label="Portal Académico - Inicio">
        &#128218; Portal Académico
      </a>
      
      <nav class="nav" role="navigation" aria-label="Navegación principal">
        <ul class="nav__list">
          <li><a href="<?= Url::to(['/site/index']) ?>" class="nav__link <?= (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') ? 'nav__link--active' : '' ?>">Inicio</a></li>
          
          <li><a href="<?= Url::to(['/materiales/index']) ?>" class="nav__link <?= (Yii::$app->controller->id == 'materiales') ? 'nav__link--active' : '' ?>">Materiales</a></li>
          
          <li><a href="<?= Url::to(['/coleccion/index']) ?>" class="nav__link">Colecciones</a></li>
          
          <li><a href="<?= Url::to(['/qand-a/index']) ?>" class="nav__link">Q&amp;A</a></li>

          
          <?php if (Yii::$app->user->isGuest): ?>
            <li><a href="<?= Url::to(['/site/login']) ?>" class="nav__link">Iniciar sesión</a></li>
            <li><a href="<?= Url::to(['/site/register']) ?>" class="btn btn--primary btn--sm">Registrarse</a></li>
          <?php else: ?>
            <li>
                <a href="<?= Url::to(['/materiales/subir']) ?>" class="btn btn--primary btn--sm" style="background-color: #28a745; border-color: #28a745;">
                    📤 Subir
                </a>
            </li>

          <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin'): ?>
              <li>
                  <a href="<?= Url::to(['/usuario/index']) ?>" class="nav__link" style="color: #d9534f; font-weight: bold;">
                      &#9881; Gestión Usuarios
                  </a>
              </li>
          <?php endif; ?>

            <li><a href="<?= Url::to(['/usuario/perfil']) ?>" class="nav__link">Mi Perfil</a></li>
             <li>
                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
                <?= Html::submitButton('Cerrar Sesión (' . Yii::$app->user->identity->username . ')', ['class' => 'nav__link btn--ghost', 'style' => 'border:none; background:none; cursor:pointer;']) ?>
                <?= Html::endForm() ?>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>
  
  <main id="main-content" class="main" role="main">
      <?= $content ?>
  </main>
  
  <footer class="footer" role="contentinfo">
    <div class="footer__container">
      <div class="footer__content">
        
        <div class="footer__section">
          <h3 class="footer__section-title">Portal Académico</h3>
          <p>Plataforma colaborativa para compartir conocimiento y recursos educativos entre estudiantes y docentes.</p>
        </div>
        
        <div class="footer__section">
          <h3 class="footer__section-title">Recursos</h3>
          <ul class="footer__list">
            <li class="footer__list-item"><a href="<?= Url::to(['/materiales/index']) ?>" class="footer__link">Explorar materiales</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/coleccion/index']) ?>" class="footer__link">Colecciones</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/dudas/index']) ?>" class="footer__link">Preguntas y respuestas</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/materiales/subir']) ?>" class="footer__link">Subir material</a></li>
          </ul>
        </div>
        
        <div class="footer__section">
          <h3 class="footer__section-title">Comunidad</h3>
          <ul class="footer__list">
            <li class="footer__list-item"><a href="<?= Url::to(['/site/guia']) ?>" class="footer__link">Guía de uso</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/site/normas']) ?>" class="footer__link">Normas de la comunidad</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/site/faq']) ?>" class="footer__link">Preguntas frecuentes</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/site/contact']) ?>" class="footer__link">Contacto</a></li>
          </ul>
        </div>
        
        <div class="footer__section">
          <h3 class="footer__section-title">Legal</h3>
          <ul class="footer__list">
            <li class="footer__list-item"><a href="<?= Url::to(['/site/terms']) ?>" class="footer__link">Términos de uso</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/site/privacy']) ?>" class="footer__link">Política de privacidad</a></li>
            <li class="footer__list-item"><a href="<?= Url::to(['/site/license']) ?>" class="footer__link">Licencias</a></li>
            <?php if (!Yii::$app->user->isGuest): ?>
                <li class="footer__list-item"><a href="<?= Url::to(['/admin/index']) ?>" class="footer__link">Administración</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      
      <div class="footer__bottom">
        <p>&copy; <?= date('Y') ?> Portal Académico. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
