<?php

use yii\helpers\Html;
use yii\bootstrap5\Tabs;
use yii\data\ActiveDataProvider;

// Modelos
use app\models\Documento;
use app\models\Coleccion;
use app\models\Pregunta;
use app\models\Respuesta;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Mi Perfil';
$this->params['breadcrumbs'][] = $this->title;

// 1. MATERIALES (Documentos subidos)
$materialesProvider = new ActiveDataProvider([
    'query' => Documento::find()->where(['autorId' => $model->id]),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
]);

// 2. COLECCIONES CREADAS (Soy el autor)
$misColeccionesProvider = new ActiveDataProvider([
    'query' => Coleccion::find()->where(['usuarioId' => $model->id]),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['fecha_actualizacion' => SORT_DESC]],
]);

// 3. COLECCIONES GUARDADAS (Me he unido a ellas)
// Usamos la relación 'usuarios' que existe en tu modelo Coleccion.php
$coleccionesGuardadasProvider = new ActiveDataProvider([
    'query' => Coleccion::find()
        ->joinWith('usuarios') // Relación many-to-many en Coleccion
        ->where(['usuario.id' => $model->id]) // Filtra donde el usuario actual está en la lista de unidos
        ->andWhere(['<>', 'coleccion.usuarioId', $model->id]), // Opcional: Excluir las que yo mismo creé
    'pagination' => ['pageSize' => 5],
]);

// 4. Q&A
$preguntasProvider = new ActiveDataProvider([
    'query' => Pregunta::find()->where(['usuarioId' => $model->id]),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
]);

$respuestasProvider = new ActiveDataProvider([
    'query' => Respuesta::find()->where(['usuarioId' => $model->id]),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
                <div class="card-header bg-white p-0">
                    <?php
                    echo Tabs::widget([
                        'navType' => 'nav-tabs card-header-tabs m-0',
                        'encodeLabels' => false,
                        'items' => [
                            [
                                'label' => '<i class="bi bi-file-earmark-text"></i> Materiales',
                                'content' => $this->render('_tab_materiales', ['dataProvider' => $materialesProvider]),
                                'active' => true,
                            ],
                            [
                                'label' => '<i class="bi bi-collection"></i> Colecciones',
                                'content' => $this->render('_tab_colecciones', [
                                    'creadasProvider' => $misColeccionesProvider,
                                    'guardadasProvider' => $coleccionesGuardadasProvider
                                ]),
                            ],
                            [
                                'label' => '<i class="bi bi-chat-dots"></i> Q&A',
                                'content' => $this->render('_tab_qa', [
                                    'preguntasProvider' => $preguntasProvider,
                                    'respuestasProvider' => $respuestasProvider
                                ]),
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="card shadow-sm border-danger mt-4">
                <div class="card-header bg-danger text-white py-1 px-3">
                    <small><strong><i class="bi bi-shield-lock"></i> Seguridad</strong></small>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped mb-0 text-muted" style="font-size: 0.85rem;">
                        <thead>
                            <tr>
                                <th>Fecha</th><th>Acción</th><th>IP</th><th>Huella Navegador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (class_exists('\app\models\UserLog')):
                                $logs = \app\models\UserLog::find()->where(['user_id' => $model->id])->orderBy(['created_at' => SORT_DESC])->limit(3)->all();
                                foreach ($logs as $log): ?>
                                <tr>
                                    <td><?= Yii::$app->formatter->asRelativeTime($log->created_at) ?></td>
                                    <td><?= Html::encode($log->action) ?></td>
                                    <td><?= Html::encode($log->ip_address) ?></td>
                                    <td><?= Html::encode($log->user_agent) ?></td>
                                </tr>
                                <?php endforeach; 
                            else: ?>
                                <tr><td colspan="3" class="text-center p-2">Logs no activos.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
