<?php
use yii\helpers\Html;

$this->title = 'Preguntas y Respuestas';
?>

<div class="site-qa">

	<h1><?= Html::encode($this->title) ?></h1>

	<p class="lead">
		A continuación se muestran algunas preguntas frecuentes
	</p>

	<div class="qa-item">
		<h4 class="qa-question">
			¿Qué es este proyecto?
		</h4>
		<p class="qa-answer">
			Es una aplicación desarrollada con Yii2 como parte del proyecto de Divulgación Académica
		</p>
	</div>

	<div class="qa-item">
		<h4 class="qa-question">
			¿Quién puede usar la plataforma?
		</h4>
		<p class="qa-answer">
			Cualquier usuario registrado en el sistema
		</p>
	</div>

	<div class="qa-item">
		<h4 class="qa-question">
			¿Se podrán enviar preguntas?
		</h4>
		<p class="qa-answer">
			Sí, en futuras versiones se permitirá enviar y responder preguntas
		</p>
	</div>

</div>

