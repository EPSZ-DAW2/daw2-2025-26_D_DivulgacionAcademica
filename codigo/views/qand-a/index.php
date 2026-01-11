<?php
/** @var yii\web\View $this */
/** @var app\models\Pregunta[] $preguntas */
/** @var array $resumen */
/** @var string $search */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dudas y Preguntas - Portal Académico';

// Mapeo de datos para las tarjetas de estadísticas
$stats = [
    'Total' => $resumen['total'],
    'Sin responder' => $resumen['sin_responder'],
    'Respondidas' => $resumen['respondida'],
    'Resueltas' => $resumen['resuelta'],
];
?>

<main id="main-content" class="main">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h1 class="mb-2 mb-md-0"><i class="bi bi-question-circle"></i> <?= Html::encode($this->title) ?></h1>
            
            <div>
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin'): ?>
                    <a href="<?= Url::to(['admin']) ?>" class="btn btn-danger me-2">
                        <i class="bi bi-shield-lock-fill"></i> Administrar
                    </a>
                <?php endif; ?>

                <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Hacer Pregunta
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <?php foreach ($stats as $label => $value): ?>
                <div class="col-md-3 col-6 mb-3">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <h2 class="display-6 fw-bold"><?= $value ?></h2>
                            <p class="text-muted mb-0"><?= $label ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="get" action="<?= Url::to(['index']) ?>" class="row g-2">
                    
                    <input type="hidden" name="r" value="qand-a/index">

                    <div class="col-md-10">
                        <input type="text" name="q" class="form-control" 
                               placeholder="Buscar por título o descripción..." 
                               value="<?= Html::encode($search ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <?php if (empty($preguntas)): ?>
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">No se encontraron preguntas.</h3>
                    <?php if (!empty($search)): ?>
                        <p>Intenta con otros términos de búsqueda.</p>
                        <a href="<?= Url::to(['index']) ?>" class="btn btn-link">Ver todas</a>
                    <?php else: ?>
                        <p>Sé el primero en preguntar algo.</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($preguntas as $model): ?>
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex">
                                <div class="me-3 text-center d-flex flex-column justify-content-center" style="min-width: 60px;">
                                    <h4 class="mb-0 fw-bold text-secondary"><?= count($model->respuestas) ?></h4>
                                    <small class="text-muted" style="font-size: 0.8rem;">respu.</small>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="mb-1">
                                        <?php 
                                        // Determinar color de la etiqueta según estado
                                        // Se usa un match seguro o fallback
                                        $estado = $model->estado ?? 'sin_responder';
                                        $claseEstado = match($estado) {
                                            'resuelta' => 'success',
                                            'respondida' => 'info',
                                            default => 'warning text-dark'
                                        };
                                        
                                        // Intentamos usar el método getEstadoTexto si existe, sino el valor crudo
                                        $textoEstado = method_exists($model, 'getEstadoTexto') ? $model->getEstadoTexto() : ucfirst($estado);
                                        ?>
                                        <span class="badge bg-<?= $claseEstado ?>">
                                            <?=Html::encode($textoEstado) ?>
                                        </span>
                                    </div>
                                    
                                    <h5 class="card-title mb-1">
                                        <a href="<?= Url::to(['view', 'id' => $model->id]) ?>" class="text-decoration-none text-dark stretched-link">
                                            <?= Html::encode($model->titulo) ?>
                                        </a>
                                    </h5>
                                    
                                    <p class="text-muted small mb-2">
                                        <?= \yii\helpers\StringHelper::truncate(Html::encode($model->descripcion), 120) ?>
                                    </p>

                                    <div class="text-muted small">
                                        <i class="bi bi-person"></i> <?= Html::encode($model->usuario->username ?? 'Anónimo') ?> &bull;
                                        <i class="bi bi-calendar"></i> <?= Yii::$app->formatter->asRelativeTime($model->fecha_creacion) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</main>
