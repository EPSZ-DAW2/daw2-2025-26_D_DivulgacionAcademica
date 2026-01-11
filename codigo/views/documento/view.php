<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Documento $model */

$this->title = $model->titulo;
?>

<div class="container">
    <header class="material-header mb-8">
        <div class="flex flex-column gap-2">
            <div class="flex align-center gap-3">
                <span class="badge <?= $model->tipo_acceso === 'publico' ? 'badge--success' : 'badge--primary' ?>">
                    <?= strtoupper($model->tipo_acceso) ?>
                </span>
                <span class="text-tertiary" style="font-size: var(--font-size-sm)">Referencia: <?= $model->archivo_url ?></span>
            </div>
            <h1 class="material-header__title"><?= Html::encode($this->title) ?></h1>
        </div>
    </header>

    <div class="grid grid--cols-1 grid--lg-cols-3 gap-8">
        <div class="grid--lg-cols-2">
            
            <div class="card shadow-lg" style="overflow: hidden; border: 1px solid #e5e7eb; border-radius: 12px;">
                <div class="flex justify-between align-center px-4 py-3" style="background: #1f2937; color: #f3f4f6; border-bottom: 1px solid #111827;">
                    <div class="flex align-center gap-3">
                        <div style="background: #ef4444; color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold;">PDF</div>
                        <span style="font-size: 13px; font-weight: 500; letter-spacing: 0.5px; color: #e5e7eb;">Vista Previa</span>
                    </div>
                    <div class="flex align-center gap-4" style="opacity: 0.9;">
                        <span style="cursor: pointer; font-size: 14px;">&#8722;</span> 
                        <span style="font-size: 12px; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px;">100%</span>
                        <span style="cursor: pointer; font-size: 14px;">&#43;</span> 
                    </div>
                </div>

                <div class="card__body p-8" style="background-color: #374151; min-height: 550px; display: flex; justify-content: center; align-items: flex-start; overflow: hidden; position: relative;">
                    
                    <div class="pdf-page-sim" style="background: white; width: 100%; max-width: 550px; padding: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border-radius: 2px; position: relative; margin-top: 10px;">
                        
                        <div style="border-bottom: 2px solid #f3f4f6; margin-bottom: 30px; padding-bottom: 15px;">
                            <h2 class="text-center" style="color: #111827; font-family: serif; font-size: 24px; margin-bottom: 5px;">
                                <?= Html::encode($model->titulo) ?>
                            </h2>
                            <p class="text-center text-tertiary" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Documento Académico</p>
                        </div>
                        
                        <div style="position: relative;">
                            <div style="filter: blur(5px); opacity: 0.4; user-select: none; color: #4b5563; font-family: serif; line-height: 1.6;">
                                <p style="margin-bottom: 15px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <p style="margin-bottom: 15px;">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                <p style="margin-bottom: 15px;">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                <p style="margin-bottom: 15px;">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                            </div>

                            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100%; background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.8) 100%); pointer-events: none;"></div>
                        </div>

                        <div class="flex justify-center align-center flex-column" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; text-align: center; z-index: 10;">
                            <div style="background: rgba(255, 255, 255, 0.95); padding: 30px; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid #e5e7eb; backdrop-filter: blur(4px);">
                                <div style="font-size: 30px; margin-bottom: 10px;">🔒</div>
                                <h4 style="margin: 0 0 8px 0; color: #111827;">Vista Previa Limitada</h4>
                                <p style="margin: 0 0 15px 0; color: #6b7280; font-size: 14px;">Descarga el archivo completo para acceder a todo el contenido.</p>
                                <span class="badge badge--primary" style="padding: 8px 16px; font-weight: normal;">
                                    Descargar PDF Completo
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <?php if ($model->tipo_acceso === 'privado' && Yii::$app->user->isGuest): ?>
                    <?= Html::a('Inicia sesión para descargar', ['site/login'], ['class' => 'btn btn--primary']) ?>
                <?php else: ?>
                    <?= Html::a('&#11015;&#65039; Descargar Material Original (PDF)', ['download', 'id' => $model->id], ['class' => 'btn btn--primary']) ?>
                <?php endif; ?>
                
                <?= Html::a('Volver', Yii::$app->request->referrer ?: ['coleccion/index'], ['class' => 'btn btn--ghost']) ?>
            </div>
        </div>

        <aside>
            <div class="card" style="border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; background: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                
                <div style="background: #f9fafb; padding: 16px 24px; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #111827; display: flex; align-items: center; gap: 8px;">
                        <span>ℹ️</span> Detalles del Recurso
                    </h3>
                </div>
                
                <div style="padding: 24px;">
                    <div class="flex flex-column gap-6">
                        
                        <div class="info-group" style="display: flex; gap: 12px;">
                            <div style="background: #eff6ff; color: #3b82f6; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 16px;">
                                📚
                            </div>
                            <div>
                                <span style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 2px;">Materia</span>
                                <p style="margin: 0; color: #1f2937; font-weight: 500; font-size: 15px;">
                                    <?= $model->materia ? Html::encode($model->materia->nombre) : 'No clasificada' ?>
                                </p>
                            </div>
                        </div>

                        <div class="info-group" style="display: flex; gap: 12px;">
                            <div style="background: #fef3c7; color: #d97706; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 16px;">
                                🎓
                            </div>
                            <div>
                                <span style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 2px;">Docente / Autor</span>
                                <p style="margin: 0; color: #1f2937; font-weight: 500; font-size: 15px;">
                                    <?= $model->autor ? Html::encode($model->autor->nombre . ' ' . $model->autor->apellidos) : 'Autor Desconocido' ?>
                                </p>
                            </div>
                        </div>

                        <div class="info-group" style="display: flex; gap: 12px;">
                            <div style="background: #f3f4f6; color: #4b5563; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 16px;">
                                🏫
                            </div>
                            <div>
                                <span style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 2px;">Institución</span>
                                <p style="margin: 0; color: #1f2937; font-weight: 500; font-size: 15px;">
                                    <?= $model->institucion ? Html::encode($model->institucion->nombre) : 'General' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="background: #ecfdf5; padding: 16px 24px; border-top: 1px solid #d1fae5;">
                    <div style="display: flex; gap: 10px; align-items: start;">
                        <span style="color: #059669; font-weight: bold;">✓</span>
                        <p style="margin: 0; font-size: 13px; color: #065f46; line-height: 1.4;">
                            Este material ha sido <strong>verificado</strong> por el personal de gestión para asegurar su calidad académica.
                        </p>
                    </div>
                </div>

            </div>
        </aside>
    </div>
</div>