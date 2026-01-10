<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Mi Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-perfil">

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center p-3 h-100">
                <div class="card-body">
                    <div style="width: 100px; height: 100px; background-color: #e9ecef; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 40px;">
                        <?= strtoupper(substr($model->username, 0, 1)) ?>
                    </div>
                    
                    <h3 class="mt-3"><?= Html::encode($model->nombre) ?></h3>
                    <p class="text-muted">@<?= Html::encode($model->username) ?></p>
                    
                    <span class="badge bg-primary fs-6">
                        <?= ucfirst($model->rol) ?>
                    </span>

                    <hr>
                    
                    <div class="text-start">
                        <p><strong><i class="bi bi-envelope"></i> Email:</strong><br> <?= Html::encode($model->email) ?></p>
                        <p><strong><i class="bi bi-calendar"></i> Miembro desde:</strong><br> <?= Yii::$app->formatter->asDate($model->fecha_registro) ?></p>
                    </div>

                    <div class="text-center mt-3">
                        <?= Html::a('Editar mis datos', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="alert alert-success shadow-sm">
                <h4 class="alert-heading">¡Hola, <?= Html::encode($model->username) ?>!</h4>
                <p>Bienvenido a tu panel personal. Aquí puedes gestionar tu información y ver tu actividad reciente.</p>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <strong><i class="bi bi-shield-lock"></i> Actividad Reciente (Seguridad)</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Acción</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // This uses the UserLog table we created in previous steps
                            // If you haven't created UserLog yet, this might error.
                            if (class_exists('\app\models\UserLog')):
                                $logs = \app\models\UserLog::find()
                                    ->where(['user_id' => $model->id])
                                    ->orderBy(['created_at' => SORT_DESC])
                                    ->limit(5)
                                    ->all();
                            
                                if ($logs):
                                    foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?= Yii::$app->formatter->asRelativeTime($log->created_at) ?></td>
                                        <td><?= Html::encode($log->action) ?></td>
                                        <td><small class="text-muted"><?= Html::encode($log->ip_address) ?></small></td>
                                    </tr>
                                    <?php endforeach; 
                                else: ?>
                                    <tr><td colspan="3" class="text-center text-muted p-3">No hay actividad reciente.</td></tr>
                                <?php endif; 
                            else: ?>
                                <tr><td colspan="3" class="text-center text-muted">Tabla de logs no configurada.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
