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
                        'resuelta' => 'success',
                        'respondida' => 'info',
                        default => 'warning text-dark'
                    };
                    ?>
                    <div>
                        <span class="badge bg-<?= $claseEstado ?> fs-6 align-self-start">
                            <?= ucfirst($model->estado) ?>
                        </span>
                        <small class="text-muted ms-2">
                            <?= Yii::$app->formatter->asDate($model->fecha_creacion, 'long') ?>
                        </small>
                    </div>

                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol == 'admin'): ?>
                        <?= Html::a('<i class="bi bi-trash"></i> Eliminar Hilo', ['delete-pregunta', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'data' => [
                                'confirm' => '¿ADMIN: Estás seguro de eliminar todo este hilo?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php endif; ?>
                </div>

                <h1 class="card-title mb-3"><?= Html::encode($model->titulo) ?></h1>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                        <span class="fw-bold text-secondary"><?= strtoupper(substr($model->usuario->username ?? 'A', 0, 1)) ?></span>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold"><?= Html::encode($model->usuario->username ?? 'Anónimo') ?></p>
                        <small class="text-muted">Autor</small>
                    </div>
                </div>

                <div class="card-text fs-5">
                    <?= nl2br(Html::encode($model->descripcion)) ?>
                </div>
            </div>
        </article>

        <section class="mb-5">
            <h3 class="mb-4"><i class="bi bi-chat-text"></i> Respuestas (<?= count($model->respuestas) ?>)</h3>
            
            <div class="d-flex flex-column gap-3">
                <?php if (empty($model->respuestas)): ?>
                    <div class="alert alert-light text-center">
                        Aún no hay respuestas. ¡Sé el primero en ayudar!
                    </div>
                <?php else: ?>
                    <?php foreach ($model->respuestas as $respuesta): ?>
                        <div class="card border-0 shadow-sm" id="respuesta-<?= $respuesta->id ?>">
                            <div class="card-body bg-light rounded position-relative">
                                
                                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol == 'admin'): ?>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <?= Html::a('<i class="bi bi-x-lg"></i>', ['delete-respuesta', 'id' => $respuesta->id], [
                                            'class' => 'text-danger',
                                            'title' => 'Eliminar respuesta (Admin)',
                                            'data' => [
                                                'confirm' => '¿Eliminar esta respuesta?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-between mb-2">
                                    <div class="fw-bold">
                                        <i class="bi bi-person-circle"></i> <?= Html::encode($respuesta->usuario->username ?? 'Usuario') ?>
                                    </div>
                                    <small class="text-muted me-4">
                                        <?= Yii::$app->formatter->asRelativeTime($respuesta->fecha) ?>
                                    </small>
                                </div>
                                <p class="mb-0">
                                    <?= nl2br(Html::encode($respuesta->contenido ?? 'Sin contenido')) ?>
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
                            <textarea name="contenido_respuesta" class="form-control" rows="5" required placeholder="Sé amable y claro en tu explicación..."></textarea>
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
