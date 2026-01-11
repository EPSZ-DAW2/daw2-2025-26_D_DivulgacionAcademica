<?php
/** @var yii\web\View $this */
/** @var app\models\Pregunta $model */
/** @var app\models\Respuesta $respuestaModel */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $model->titulo . ' - Portal Académico';
?>

<main id="main-content" class="main mt-4">
    <div class="container" style="max-width: 900px;">
        
        <div class="mb-4">
            <a href="<?= Url::to(['index']) ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
        </div>

        <article class="card mb-5 shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3">
                    <?php 
                    $claseEstado = match($model->estado) {
                        'resolved' => 'success',
                        'answered' => 'info',
                        default => 'warning text-dark'
                    };
                    ?>
                    <span class="badge bg-<?= $claseEstado ?> fs-6 align-self-start">
                        <?= ucfirst($model->estado) ?>
                    </span>
                    <small class="text-muted">
                        <?= Yii::$app->formatter->asDate($model->fecha_creacion, 'long') ?>
                    </small>
                </div>

                <h1 class="card-title mb-3"><?= Html::encode($model->titulo) ?></h1>
                
                <div class="d-flex align-items-center text-muted mb-4">
                    <div style="width:32px; height:32px; background:#eee; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:10px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span><?= Html::encode($model->usuario->username ?? 'Anónimo') ?></span>
                </div>

                <div class="card-text fs-5 text-dark border-top pt-3">
                    <?= nl2br(Html::encode($model->descripcion)) ?> 
                </div>
            </div>
        </article>

        <section class="mb-5">
            <h3 class="mb-4"><i class="bi bi-chat-left-text"></i> Respuestas (<?= count($model->respuestas) ?>)</h3>
            
            <div class="vstack gap-3">
                <?php if (empty($model->respuestas)): ?>
                    <p class="text-muted fst-italic">Aún no hay respuestas.</p>
                <?php else: ?>
                    <?php foreach ($model->respuestas as $respuesta): ?>
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold text-primary">
                                        <?= Html::encode($respuesta->usuario->username ?? 'Usuario') ?>
                                    </h6>
                                    <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($respuesta->fecha_creacion ?? date('Y-m-d')) ?></small>
                                </div>
                                
                                <p class="card-text mt-2">
                                    <?= nl2br(Html::encode($respuesta->contenido ?? $respuesta->descripcion ?? 'Sin contenido')) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">
                <h4 class="card-title mb-3">Tu Respuesta</h4>
                
                <?php if (Yii::$app->user->isGuest): ?>
                    <div class="alert alert-info">
                        Debes <a href="<?= Url::to(['site/login']) ?>" class="alert-link">iniciar sesión</a> para responder.
                    </div>
                <?php else: ?>
                    
                    <?php $form = ActiveForm::begin([
                        'action' => ['responder', 'id' => $model->id],
                    ]); ?>

                        <div class="mb-3">
                            <label class="form-label">Escribe tu solución:</label>
                            <textarea name="contenido_respuesta" class="form-control" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send"></i> Publicar Respuesta
                        </button>

                    <?php ActiveForm::end(); ?>
                    
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
