<?php

namespace app\models;

use yii\db\ActiveRecord;

class Respuesta extends ActiveRecord
{
	public static function tableName()
	{
		return 'respuesta';
	}

	public function getUsuario()
	{
		return $this->hasOne(Usuario::class, ['id' => 'usuarioId']);
	}
}

