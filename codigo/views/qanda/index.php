<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Preguntas y Respuestas';
?>

<div class="site-qa">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <!-- FILTROS Y BÚSQUEDA -->
    <div class="qa-filters">

        <form class="row g-3 align-items-end">

            <!-- BUSCAR -->
            <div class="col-md-4">
                <label class="form-label">Buscar duda</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar por texto..."
                >
            </div>

            <!-- CATEGORÍA -->
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

            <!-- ESTADO -->
            <div class="col-md-4">
                <label class="form-label">Estado</label>
                <select class="form-select">
                    <option selected>Todos</option>
                    <option>Sin responder</option>
                    <option>Respondida</option>
                    <option>Resuelta</option>
                </select>
            </div>

        </form>

    </div>
    
    <!-- RESUMEN DE DUDAS -->
    <div class="qa-summary">

        <button class="qa-summary-btn" disabled>
            <div class="qa-number">12</div>
            <div>Total</div>
        </button>

        <button class="qa-summary-btn" disabled>
            <div class="qa-number">5</div>
            <div>Sin responder</div>
        </button>

        <button class="qa-summary-btn" disabled>
            <div class="qa-number">4</div>
            <div>Respondidas</div>
        </button>

        <button class="qa-summary-btn" disabled>
            <div class="qa-number">3</div>
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

            <button class="qa-summary-btn" disabled>
                Enviar pregunta
            </button>

            <p class="text-muted mt-2">
                * Funcionalidad no implementada
            </p>
        </form>
    </div>

    <hr>

    <!-- LISTADO Q&A -->
    <div class="qa-list">

        <h3>Preguntas recientes</h3>

        <!-- PREGUNTA SIN RESPUESTA -->
        <div class="qa-item pending">
            <p class="qa-question">
                ❓ ¿Cuándo se publican las notas finales?
            </p>
            <p class="qa-meta">
                Alumno · 12/01/2026 · <span class="badge bg-warning">Pendiente</span>
            </p>
        </div>

        <!-- PREGUNTA RESPONDIDA -->
        <div class="qa-item answered">
            <p class="qa-question">
                ❓ ¿Se puede entregar la práctica fuera de plazo?
            </p>
            <p class="qa-meta">
                Alumno · 10/01/2026 · <span class="badge bg-success">Respondida</span>
            </p>

            <div class="qa-answer">
                <p>
                    ✔ Sí, con una penalización del 20% si se entrega dentro de la semana siguiente.
                </p>
                <p class="qa-teacher">
                    Profesor: Juan Pérez
                </p>
            </div>
        </div>

    </div>

</div>

