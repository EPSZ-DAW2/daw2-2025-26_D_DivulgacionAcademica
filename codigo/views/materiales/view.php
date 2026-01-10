<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Documento $model */
/** @var app\models\DocumentoComentario $nuevoComentario */

$this->title = $model->titulo;
$rating = $model->getRatingPromedio(); 
$votos = $model->getTotalVotos();

// --- LÓGICA DE ARCHIVO ---
$rutaArchivo = 'uploads/' . $model->archivo_url;
$existeArchivo = file_exists($rutaArchivo);
$tamano = $existeArchivo ? round(filesize($rutaArchivo) / 1024 / 1024, 2) . ' MB' : 'Desconocido';
$fechaSubida = $existeArchivo ? date('d/m/Y', filemtime($rutaArchivo)) : date('d/m/Y');

// Detectar extensión para iconos y texto
$ext = strtolower(pathinfo($model->archivo_url, PATHINFO_EXTENSION));
$tipoInfo = [
    'pdf' => ['icon' => '📄', 'label' => 'PDF (Documento)'],
    'doc' => ['icon' => '📝', 'label' => 'Word (Documento)'],
    'docx' => ['icon' => '📝', 'label' => 'Word (Documento)'],
    'xls' => ['icon' => '📊', 'label' => 'Excel (Hoja de cálculo)'],
    'xlsx' => ['icon' => '📊', 'label' => 'Excel (Hoja de cálculo)'],
    'ppt' => ['icon' => '📽️', 'label' => 'PowerPoint (Presentación)'],
    'pptx' => ['icon' => '📽️', 'label' => 'PowerPoint (Presentación)'],
    'mp4' => ['icon' => '🎥', 'label' => 'Video MP4'],
];
$info = $tipoInfo[$ext] ?? ['icon' => '📁', 'label' => strtoupper($ext) . ' (Archivo)'];
?>

<div class="container py-5">
    
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <?= Yii::$app->session->getFlash('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge <?= ($model->tipo_acceso == 'privado') ? 'bg-secondary' : 'bg-primary' ?> me-2">
                            <?= ($model->tipo_acceso == 'privado') ? '🔒 Examen / Privado' : '🔓 Apuntes / Público' ?>
                        </span>
                        
                        <div class="text-warning small ms-auto" title="Valoración media: <?= $rating ?>">
                            <?php 
                                for($i=1; $i<=5; $i++) {
                                    echo ($i <= round($rating)) ? '★' : '☆';
                                }
                            ?>
                            <span class="text-muted ms-1 text-dark">(<?= $rating ?>/5 - <?= $votos ?> votos)</span>
                        </div>
                    </div>
                    
                    <h1 class="display-5 fw-bold mb-4"><?= Html::encode($model->titulo) ?></h1>
                    
                    <div class="row g-4 mb-4 py-3 border-top border-bottom">
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Autor/a</small>
                            <span class="fw-bold">👤 <?= $model->autor ? Html::encode($model->autor->nombre . ' ' . $model->autor->apellidos) : 'Anónimo' ?></span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Materia</small>
                            <span class="fw-bold">📂 <?= $model->materia ? Html::encode($model->materia->nombre) : 'General' ?></span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Institución</small>
                            <span class="fw-bold">🏫 <?= $model->institucion ? Html::encode($model->institucion->nombre) : 'N/A' ?></span>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-start mt-4">
                        
                        <?php if ($existeArchivo): ?>
                            <a href="<?= Url::to('@web/uploads/' . $model->archivo_url) ?>" class="btn btn-primary btn-lg px-4" target="_blank" download>
                                ⬇️ Descargar <?= strtoupper($ext) ?> (<?= $tamano ?>)
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg px-4" disabled>⚠️ No disponible</button>
                        <?php endif; ?>
                        
                        <?= Html::a('📚 Añadir a colección', ['coleccion/agregar-material', 'docId' => $model->id], ['class' => 'btn btn-outline-primary btn-lg px-4']) ?>
                        
                        <a href="<?= Url::to(['materiales/index']) ?>" class="btn btn-link text-muted px-4 ms-auto">Volver al listado</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mb-4">
                    
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold border-bottom pb-3 mb-3">📖 Información del archivo</h5>
                            <div class="row">
                                <div class="col-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <span class="text-muted">Fichero:</span> 
                                            <span class="font-monospace text-break"><?= Html::encode($model->archivo_url) ?></span>
                                        </li>
                                        <li>
                                            <span class="text-muted">Formato:</span> 
                                            <span><?= $info['icon'] ?> <?= $info['label'] ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><span class="text-muted">Fecha Subida:</span> <?= $fechaSubida ?></li>
                                        <li><span class="text-muted">Tamaño:</span> <?= $tamano ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="h4 mb-4">💬 Comentarios (<?= count($model->comentarios) ?>)</h3>
                            
                            <?php if (empty($model->comentarios)): ?>
                                <div class="text-center py-4 text-muted bg-light rounded mb-4">
                                    <p class="mb-0">Nadie ha comentado aún. ¡Sé el primero en opinar!</p>
                                </div>
                            <?php else: ?>
                                <div class="comments-list mb-5">
                                    <?php foreach ($model->comentarios as $comentario): ?>
                                        <div class="d-flex mb-3 pb-3 border-bottom">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary" style="width:40px; height:40px; font-size:1.2rem;">
                                                    <?= strtoupper(substr($comentario->usuario ? $comentario->usuario->nombre : '?', 0, 1)) ?>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    <?= Html::encode($comentario->usuario ? $comentario->usuario->nombre : 'Usuario') ?>
                                                </h6>
                                                <small class="text-muted d-block mb-2">
                                                    <?= Yii::$app->formatter->asDate($comentario->fecha, 'long') ?>
                                                </small>
                                                <p class="mb-0 text-dark"><?= nl2br(Html::encode($comentario->contenido)) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="bg-light p-4 rounded">
                                <?php if (Yii::$app->user->isGuest): ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-3">Debes iniciar sesión para dejar un comentario.</p>
                                        <a href="<?= Url::to(['site/login']) ?>" class="btn btn-primary px-4">🔐 Iniciar Sesión</a>
                                    </div>
                                <?php else: ?>
                                    <h5 class="mb-3">Deja tu opinión</h5>
                                    <?php $form = ActiveForm::begin(); ?>
                                        <div class="mb-3">
                                            <?= $form->field($nuevoComentario, 'contenido')
                                                ->textarea(['rows' => 3, 'placeholder' => 'Escribe aquí tu opinión...', 'class' => 'form-control'])
                                                ->label(false) ?>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Publicando como: <strong><?= Html::encode(Yii::$app->user->identity->nombre) ?></strong></small>
                                            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                                        </div>
                                    <?php ActiveForm::end(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body text-center">
                            <h5 class="text-muted mb-3">¿Te ha servido?</h5>
                            <?php if (Yii::$app->user->isGuest): ?>
                                <div class="p-3">
                                    <p class="small text-muted mb-3">Inicia sesión para valorar.</p>
                                    <a href="<?= Url::to(['site/login']) ?>" class="btn btn-outline-primary btn-sm">Acceder</a>
                                </div>
                            <?php else: ?>
                                <p class="small mb-2">Haz clic para valorar:</p>
                                <div class="rating-buttons mb-3 d-flex justify-content-center">
                                    <?php foreach([1, 2, 3, 4, 5] as $num): ?>
                                        <a href="<?= Url::to(['materiales/valorar', 'id' => $model->id, 'puntuacion' => $num]) ?>" 
                                           class="btn btn-outline-warning btn-sm mx-1 text-dark shadow-sm d-flex align-items-center justify-content-center" 
                                           title="Dar <?= $num ?> estrellas"
                                           style="width: 35px; height: 35px; font-size: 1.2rem; padding: 0;">
                                           ★
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <small class="text-muted">Tu voto ayuda a mejorar el contenido.</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>