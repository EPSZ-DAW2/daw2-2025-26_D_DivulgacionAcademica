<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Documento $model */

$this->title = $model->titulo;
?>

<div class="container">
    <header class="material-header mb-8">
        <div class="flex flex-column gap-2">
            <div class="flex align-center gap-3">
                <span class="badge <?= $model->tipo_acceso === 'publico' ? 'badge--success' : 'badge--primary' ?>">
                    <?= strtoupper($model->tipo_acceso) ?>
                </span>
                <span class="text-tertiary" style="font-size: var(--font-size-sm)">Referencia: <?= $model->archivo_url ?></span>
            </div>
            <h1 class="material-header__title"><?= Html::encode($this->title) ?></h1>
        </div>
    </header>

    <div class="grid grid--cols-1 grid--lg-cols-3 gap-8">
        <div class="grid--lg-cols-2">
            <div class="card shadow-md" style="overflow: hidden; border: none;">
                <div class="flex justify-between p-3" style="background: #323639; color: #fff; border-bottom: 1px solid #000;">
                    <div class="flex align-center gap-4">
                        <span style="font-size: 14px; font-weight: 500;">&#128196; Preview_Mode.pdf</span>
                    </div>
                    <div class="flex align-center gap-6" style="opacity: 0.8;">
                        <span>&#128269; 100%</span>
                        <span>&#128448;</span>
                        <span>&#128461;</span>
                    </div>
                </div>

                <div class="card__body p-12" style="background: #525659; min-height: 500px; display: flex; justify-content: center;">
                    <div class="pdf-page-sim" style="background: white; width: 90%; max-width: 600px; padding: 60px; box-shadow: 0 4px 20px rgba(0,0,0,0.4); position: relative;">
                        <h2 class="text-center mb-8" style="color: #333; border-bottom: 2px solid #eee; padding-bottom: 20px;">
                            <?= Html::encode($model->titulo) ?>
                        </h2>
                        
                        <div style="filter: blur(4px); opacity: 0.3; pointer-events: none; user-select: none;">
                            <p style="margin-bottom: 20px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <p style="margin-bottom: 20px;">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                        </div>

                        <div class="flex justify-center" style="position: absolute; top: 60%; left: 0; right: 0;">
                            <span class="badge badge--primary" style="box-shadow: var(--shadow-md); padding: 10px 20px;">
                                Descarga el PDF completo para leer el material
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <?php if ($model->tipo_acceso === 'privado' && Yii::$app->user->isGuest): ?>
                    <?= Html::a('Inicia sesión para descargar', ['site/login'], ['class' => 'btn btn--primary']) ?>
                <?php else: ?>
                    <?= Html::a('&#11015;&#65039; Descargar Material Original (PDF)', ['download', 'id' => $model->id], ['class' => 'btn btn--primary']) ?>
                <?php endif; ?>
                
                <?= Html::a('Volver', Yii::$app->request->referrer ?: ['coleccion/index'], ['class' => 'btn btn--ghost']) ?>
            </div>
        </div>

        <aside>
            <div class="card p-6 bg-secondary">
                <h3 class="card__title mb-6">Detalles del Recurso</h3>
                
                <div class="flex flex-column gap-6">
                    <div class="info-group">
                        <span class="text-tertiary block mb-1" style="font-size: var(--font-size-xs); font-weight: bold;">MATERIA</span>
                        <p><?= $model->materia ? Html::encode($model->materia->nombre) : 'No clasificada' ?></p>
                    </div>

                    <div class="info-group">
                        <span class="text-tertiary block mb-1" style="font-size: var(--font-size-xs); font-weight: bold;">DOCENTE / AUTOR</span>
                        <p><?= $model->autor ? Html::encode($model->autor->nombre . ' ' . $model->autor->apellidos) : 'Autor Desconocido' ?></p>
                    </div>

                    <div class="info-group">
                        <span class="text-tertiary block mb-1" style="font-size: var(--font-size-xs); font-weight: bold;">INSTITUCIÓN</span>
                        <p><?= $model->institucion ? Html::encode($model->institucion->nombre) : 'General' ?></p>
                    </div>
                </div>

                <div class="mt-8 pt-6" style="border-top: 1px solid var(--color-gray-300);">
                    <p class="text-tertiary" style="font-size: var(--font-size-sm); font-style: italic;">
                        Este material ha sido verificado por el personal de gestión para asegurar su calidad académica.
                    </p>
                </div>
            </div>
        </aside>
    </div>
</div>