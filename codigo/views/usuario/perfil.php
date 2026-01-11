<?php

use yii\helpers\Html;
use yii\bootstrap5\Tabs;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

// Importar modelos
use app\models\Documento;
use app\models\DocumentoComentario; // Preguntas y respuestas (Comentarios)
use app\models\UsuarioColeccion;    // Tabla pivote para Colecciones
// use app\models\Incidencia;       // Descomenta si Q&A se refiere a tickets de soporte

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Mi Perfil';
$this->params['breadcrumbs'][] = $this->title;

// 1. DATA PROVIDER: MATERIALES (Documentos subidos por el usuario)
$materialesProvider = new ActiveDataProvider([
    'query' => Documento::find()->where(['autorId' => $model->id]),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
]);

// 2. DATA PROVIDER: COLECCIONES 
// Asumiendo que 'usuario_coleccion' es la tabla que vincula al usuario con sus colecciones guardadas.
// Si tienes un modelo Coleccion relacionado, usa joinWith.
$coleccionesProvider = new ActiveDataProvider([
    'query' => \app\models\Coleccion::find()
        ->joinWith('usuarios') // Asumiendo relación en Coleccion: getUsuarios() via usuario_coleccion
        ->where(['usuario.id' => $model->id]), // Filtra colecciones donde este usuario está vinculado
    'pagination' => ['pageSize' => 5],
]);
// NOTA: Si no tienes la relación definida en el modelo Coleccion, usa esto temporalmente:
/*
$coleccionesProvider = new ActiveDataProvider([
    'query' => \app\models\UsuarioColeccion::find()->where(['usuarioId' => $model->id]),
]);
*/

// 3. DATA PROVIDER: PREGUNTAS Y RESPUESTAS
// Aquí mostramos los comentarios que el usuario ha hecho en documentos (Interacción Q&A)
$qaProvider = new ActiveDataProvider([
    'query' => DocumentoComentario::find()->where(['usuarioId' => $model->id]),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['fecha' => SORT_DESC]],
]);

?>
<div class="usuario-perfil">

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center p-3 h-100">
                <div class="card-body">
                    <div class="mb-3" style="width: 100px; height: 100px; background-color: #e9ecef; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 40px;">
                        <?= strtoupper(substr($model->username, 0, 1)) ?>
                    </div>
                    
                    <h3 class="card-title"><?= Html::encode($model->nombre) ?></h3>
                    <p class="text-muted">@<?= Html::encode($model->username) ?></p>
                    <span class="badge bg-primary mb-3"><?= ucfirst($model->rol) ?></span>

                    <ul class="list-group list-group-flush text-start mt-3">
                        <li class="list-group-item px-0">
                            <strong><i class="bi bi-envelope"></i> Email:</strong> <br>
                            <?= Html::encode($model->email) ?>
                        </li>
                        <li class="list-group-item px-0">
                            <strong><i class="bi bi-calendar"></i> Miembro desde:</strong> <br>
                            <?= Yii::$app->formatter->asDate($model->fecha_registro) ?>
                        </li>
                    </ul>

                    <div class="mt-4">
                        <?= Html::a('<i class="bi bi-pencil"></i> Editar Datos', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary w-100']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <?php
                    echo Tabs::widget([
                        'navType' => 'nav-tabs card-header-tabs',
                        'encodeLabels' => false,
                        'items' => [
                            [
                                'label' => '<i class="bi bi-file-earmark-text"></i> Mis Materiales',
                                'content' => $this->render('_tab_materiales', ['dataProvider' => $materialesProvider]),
                                'active' => true,
                            ],
                            [
                                'label' => '<i class="bi bi-collection"></i> Mis Colecciones',
                                'content' => $this->render('_tab_colecciones', ['dataProvider' => $coleccionesProvider]),
                            ],
                            [
                                'label' => '<i class="bi bi-chat-dots"></i> Preguntas/Respuestas',
                                'content' => $this->render('_tab_qa', ['dataProvider' => $qaProvider]),
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <strong><i class="bi bi-shield-lock-fill"></i> Historial de Seguridad (Logs)</strong>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 text-small">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Acción</th>
                                    <th>IP</th>
                                    <th>Navegador</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Asegurar que el modelo UserLog existe o usar datos dummy si no
                                if (class_exists('\app\models\UserLog')):
                                    $logs = \app\models\UserLog::find()
                                        ->where(['user_id' => $model->id])
                                        ->orderBy(['created_at' => SORT_DESC])
                                        ->limit(5) // Solo los últimos 5
                                        ->all();
                                    
                                    if ($logs):
                                        foreach ($logs as $log): ?>
                                        <tr>
                                            <td style="white-space:nowrap;"><?= Yii::$app->formatter->asRelativeTime($log->created_at) ?></td>
                                            <td><span class="badge bg-secondary"><?= Html::encode($log->action) ?></span></td>
                                            <td><small class="font-monospace"><?= Html::encode($log->ip_address) ?></small></td>
                                            <td class="text-truncate" style="max-width: 150px;" title="<?= Html::encode($log->user_agent) ?>">
                                                <small class="text-muted"><?= Html::encode($log->user_agent) ?></small>
                                            </td>
                                        </tr>
                                        <?php endforeach; 
                                    else: ?>
                                        <tr><td colspan="4" class="text-center text-muted p-3">Sin actividad reciente registrada.</td></tr>
                                    <?php endif; 
                                else: ?>
                                    <tr><td colspan="4" class="text-center text-muted p-3"><em>El sistema de logs no está activo.</em></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-end">
                    <small class="text-muted">Solo tú puedes ver este historial.</small>
                </div>
            </div>

        </div>
    </div>
</div>
