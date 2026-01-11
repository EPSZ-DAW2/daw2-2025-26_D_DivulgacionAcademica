<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Añadir a mis colecciones';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white p-4">
                    <h4 class="mb-0">Añadir Material</h4>
                    <small>Documento: <strong><?= Html::encode($documento->titulo) ?></strong></small>
                </div>
                
                <div class="card-body p-5">
                    <?php if (empty($misColecciones)): ?>
                        <div class="alert alert-info">
                            Parece que aún no has creado ninguna colección propia. 
                            <?= Html::a('¡Crea tu primera colección aquí!', ['create'], ['class' => 'fw-bold']) ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-4">Selecciona las colecciones donde quieres incluir este recurso:</p>
                        
                        <?php $form = ActiveForm::begin(['action' => ['guardar-material', 'docId' => $documento->id]]); ?>
                            
                            <div class="list-group mb-4">
                                <?php foreach ($misColecciones as $col): ?>
                                    <label class="list-group-item d-flex gap-3 py-3">
                                        <input class="form-check-input flex-shrink-0" type="checkbox" name="colecciones[]" value="<?= $col->id ?>">
                                        <span class="pt-1">
                                            <strong class="d-block"><?= Html::encode($col->titulo) ?></strong>
                                            <small class="text-muted"><?= count($col->documentos) ?> materiales actualmente</small>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="d-flex gap-3">
                                <?= Html::submitButton('Confirmar Selección', ['class' => 'btn btn--primary flex-1']) ?>
                                <?= Html::a('Cancelar', ['materiales/view', 'id' => $documento->id], ['class' => 'btn btn--ghost']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>