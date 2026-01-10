<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

// Registramos tus estilos
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
          <li>
            <a href="<?= Url::to(['/site/index']) ?>" class="nav__link <?= (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') ? 'nav__link--active' : '' ?>">
                Inicio
            </a>
          </li>
          
          <li><a href="<?= Url::to(['/materiales/index']) ?>" class="nav__link">Materiales</a></li>
          <li><a href="<?= Url::to(['/foro/index']) ?>" class="nav__link">Foro</a></li>
          <li><a href="<?= Url::to(['/eventos/index']) ?>" class="nav__link">Eventos</a></li>
          <li><a href="<?= Url::to(['/coleccion/index']) ?>" class="nav__link">Colecciones</a></li>

          <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin'): ?>
              <li>
                  <a href="<?= Url::to(['/usuario/index']) ?>" class="nav__link" style="color: #d9534f; font-weight: bold;">
                      &#9881; Gestión Usuarios
                  </a>
              </li>
          <?php endif; ?>
        </ul>
      </nav>
      
      <div class="header__auth" style="display: flex; align-items: center; gap: 15px;">
        <?php if (Yii::$app->user->isGuest): ?>
            <a href="<?= Url::to(['/site/login']) ?>" class="nav__link">Iniciar sesión</a>
            <a href="<?= Url::to(['/site/register']) ?>" class="btn btn--primary btn--sm">Registrarse</a>
        <?php else: ?>
            <span class="header__user-welcome" style="margin-right: 5px; color: #666;">
                Hola, <?= Html::encode(Yii::$app->user->identity->username) ?>
            </span>
            
            <a href="<?= Url::to(['/usuario/perfil']) ?>" class="nav__link">
                Mi Perfil
            </a>

            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline', 'style' => 'margin: 0;']) ?>
                <?= Html::submitButton(
                    'Cerrar Sesión',
                    [
                        'class' => 'button', 
                        'style' => 'background-color: #dc2626; color: white; border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.9rem; cursor: pointer; font-weight: 500;'
                    ]
                ) ?>
            
        <?php endif; ?>
      </div>
    </div>
  </header>

  <main class="main-content" role="main">
    <div class="container">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </div>
  </main>

  <footer class="footer" role="contentinfo">
    <div class="footer__container">
      <div class="footer__content">
        <div class="footer__section">
          <h3 class="footer__section-title">Sobre nosotros</h3>
          <p>Plataforma colaborativa para la divulgación académica y científica. Conectando conocimiento.</p>
        </div>
        
        <div class="footer__section">
          <h3 class="footer__section-title">Enlaces rápidos</h3>
          <ul class="footer__list">
            <li class="footer__list-item"><a href="<?= Url::to(['/site/guide']) ?>" class="footer__link">Guía de uso</a></li>
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
