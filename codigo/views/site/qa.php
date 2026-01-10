<?php
use yii\helpers\Html;

$this->title = 'Preguntas y Respuestas';
?>

<div class="site-qa">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <!-- FILTROS Y BÚSQUEDA -->
    <div class="qa-filters">
        <form class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Buscar duda</label>
                <input type="text" class="form-control" placeholder="Buscar por texto...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Categoría</label>
                <select class="form-select">
                    <option selected>Todas las categorías</option>
                    <option>Programación</option>
                    <option>Matemáticas</option>
                    <option>Bases de Datos</option>
                    <option>Sistemas</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Estado</label>
                <select class="form-select">
                    <option selected>Todos</option>
                    <option value="pendiente">Sin responder</option>
                    <option value="respondida">Respondida</option>
                    <option value="resuelta">Resuelta</option>
                </select>
            </div>
        </form>
    </div>
    
    <!-- RESUMEN DE DUDAS -->
    <div class="qa-summary">
        <?php
        $total = count($preguntas);
        $sinResponder = count(array_filter($preguntas, fn($p) => empty($p->respuestas)));
        $respondidas = count(array_filter($preguntas, fn($p) => !empty($p->respuestas) && $p->estado == 'respondida'));
        $resueltas = count(array_filter($preguntas, fn($p) => $p->estado == 'resuelta'));
        ?>
        <button class="qa-summary-btn" disabled>
            <div class="qa-number"><?= $total ?></div>
            <div>Total</div>
        </button>

        <button class="qa-summary-btn" disabled>
            <div class="qa-number"><?= $sinResponder ?></div>
            <div>Sin responder</div>
        </button>

        <button class="qa-summary-btn" disabled>
            <div class="qa-number"><?= $respondidas ?></div>
            <div>Respondidas</div>
        </button>

        <button class="qa-summary-btn" disabled>
            <div class="qa-number"><?= $resueltas ?></div>
            <div>Resueltas</div>
        </button>
    </div>

    <hr>

    <!-- FORMULARIO ALUMNO -->
    <div class="qa-form">
        <h3>Enviar una pregunta</h3>
        <form>
            <div class="form-group mb-3">
                <label>Pregunta</label>
                <textarea class="form-control" rows="3" placeholder="Escribe tu pregunta..."></textarea>
            </div>
            <button class="qa-summary-btn" disabled>Enviar pregunta</button>
        </form>
    </div>

    <hr>

    <!-- LISTADO Q&A -->
    <div class="qa-list">
        <h3>Preguntas recientes</h3>

        <?php foreach ($preguntas as $pregunta): ?>
            <?php
                $estadoClass = '';
                $estadoLabel = '';
                $badgeClass = '';

                if(empty($pregunta->respuestas)) {
                    // Sin respuesta
                    $estadoClass = 'pending';
                    $estadoLabel = 'No respondida';
                    $badgeClass = 'bg-warning';
                } elseif($pregunta->estado == 'respondida') {
                    $estadoClass = 'answered';
                    $estadoLabel = 'Respondida';
                    $badgeClass = 'bg-success';
                } elseif($pregunta->estado == 'resuelta') {
                    $estadoClass = 'resolved';
                    $estadoLabel = 'Resuelta';
                    $badgeClass = 'bg-primary';
                }
            ?>

            <div class="qa-item <?= $estadoClass ?>">
                <p class="qa-question">❓ <?= Html::encode($pregunta->titulo) ?></p>
                <p class="qa-meta">
                    <?= Html::encode($pregunta->usuario->username ?? 'Alumno') ?> · 
                    <?= Yii::$app->formatter->asDate($pregunta->fecha_creacion) ?> · 
                    <span class="badge <?= $badgeClass ?>"><?= $estadoLabel ?></span>
                </p>

                <p class="qa-description"><?= Html::encode($pregunta->descripcion) ?></p>

                <?php if(!empty($pregunta->respuestas)): ?>
                    <?php foreach($pregunta->respuestas as $respuesta): ?>
                        <div class="qa-answer">
                            <p>✔ <?= Html::encode($respuesta->contenido) ?></p>
                            <p class="qa-teacher">
                                Profesor: <?= Html::encode($respuesta->usuario->username ?? 'Profesor') ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
    </div>

</div>

