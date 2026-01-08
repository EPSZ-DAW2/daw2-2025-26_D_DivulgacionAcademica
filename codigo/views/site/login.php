<?php

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Iniciar sesión';
?>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-5 col-lg-4">

			<div class="card shadow mt-5">
				<div class="card-body p-4">

					<h3 class="text-center mb-3">
						<?= Html::encode($this->title) ?>
					</h3>

					<p class="text-center text-muted mb-4">
						Introduce tus credenciales para acceder al sistema
					</p>

					<?php if ($model->hasErrors()): ?>
						<div class="alert alert-danger">
							<?= Html::errorSummary($model) ?>
						</div>
					<?php endif; ?>

					<?php $form = ActiveForm::begin([
						'id' => 'login-form',
					]); ?>

						<?= $form->field($model, 'username')
							->textInput([
								'autofocus' => true,
								'placeholder' => 'Usuario',
							])
							->label(false) ?>

						<?= $form->field($model, 'password')
							->passwordInput([
								'placeholder' => 'Contraseña',
							])
							->label(false) ?>

						<?= $form->field($model, 'rememberMe')->checkbox() ?>

						<div class="d-grid mt-4">
							<?= Html::submitButton('Entrar', [
								'class' => 'btn btn-primary btn-lg',
								'name' => 'login-button'
							]) ?>
						</div>

					<?php ActiveForm::end(); ?>

				</div>
			</div>

		</div>
	</div>
</div>

