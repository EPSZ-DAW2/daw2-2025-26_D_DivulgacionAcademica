<?php
/** @var yii\web\View $this */
/** @var app\models\Pregunta[] $preguntas */
/** @var array $resumen */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dudas y Preguntas - Portal Académico';

$stats = [
    'Total' => $resumen['total'],
    'Sin responder' => $resumen['sin_responder'],
    'Respondidas' => $resumen['respondida'],
    'Resueltas' => $resumen['resuelta'],
];
?>

<main id="main-content" class="main">
    <div class="container">

        <!-- Título y botón -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h1 class="mb-2 mb-md-0"><i class="bi bi-question-circle"></i> <?= Html::encode($this->title) ?></h1>
            <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Hacer Pregunta
            </a>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <?php foreach ($stats as $label => $value): ?>
                <div class="col-md-3 col-6 mb-3">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <h2 class="display-6 fw-bold"><?= $value ?></h2>
                            <p class="text-muted mb-0"><?= Html::encode($label) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Formulario de búsqueda y filtrado -->
        <div class="card mb-4 bg-light border-0">
            <div class="card-body">
                <form action="<?= Url::to(['index']) ?>" method="get">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="flex-grow-1">
                            <label class="form-label">Buscar</label>
                            <input type="text" name="q" class="form-control" placeholder="Título o contenido...">
                        </div>
                        <div style="min-width: 200px;">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="pending">Sin responder</option>
                                <option value="answered">Respondida</option>
                                <option value="resolved">Resuelta</option>
                            </select>
                        </div>
                        <div style="min-width: 150px; align-self: flex-end;">
                            <button type="submit" class="btn btn-secondary w-100">Filtrar resultados</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de preguntas -->
        <div class="qa-list">
            <?php if (empty($preguntas)): ?>
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-inbox fs-1"></i><br>
                    No se encontraron preguntas con estos criterios.
                </div>
            <?php else: ?>
                <?php foreach ($preguntas as $model): ?>
                    <div class="card mb-3 shadow-sm hover-effect">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <div class="mb-2">
                                        <?php 
                                        $claseEstado = match($model->estado) {
                                            'resolved' => 'success',
                                            'answered' => 'info',
                                            default => 'warning text-dark'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $claseEstado ?>">
                                            <?= ucfirst($model->estado) ?>
                                        </span>
                                    </div>
                                    
                                    <h4 class="card-title mb-1">
                                        <a href="<?= Url::to(['view', 'id' => $model->id]) ?>" class="text-decoration-none text-dark stretched-link">
                                            <?= Html::encode($model->titulo) ?>
                                        </a>
                                    </h4>
                                    
                                    <div class="text-muted small mt-2">
                                        <i class="bi bi-person"></i> <?= Html::encode($model->usuario->username ?? 'Anónimo') ?> &bull;
                                        <i class="bi bi-calendar"></i> <?= Yii::$app->formatter->asRelativeTime($model->fecha_creacion) ?> &bull;
                                        <i class="bi bi-chat-dots"></i> <?= count($model->respuestas) ?> respuestas
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

