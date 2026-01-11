<?php

namespace app\models;

use yii\db\ActiveRecord;

class Pregunta extends ActiveRecord
{
	public static function tableName()
	{
		return 'pregunta';
	}

	public function getRespuestas()
	{
		return $this->hasMany(Respuesta::class, ['preguntaId' => 'id']);
	}

	public function getMateria()
	{
		return $this->hasOne(Materia::class, ['id' => 'materiaId']);
	}

	public function getUsuario()
	{
		return $this->hasOne(Usuario::class, ['id' => 'usuarioId']);
	}
}

