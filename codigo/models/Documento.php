<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Documento extends ActiveRecord
{
    // Nombre de la tabla en tu base de datos
    public static function tableName()
    {
        return 'documento';
    }

    // Reglas básicas para que no dé error al validar
    public function rules()
    {
        return [
            [['titulo', 'archivo_url'], 'required'],
            [['materiaId', 'autorId', 'institucionId'], 'integer'],
            [['tipo_acceso'], 'string'],
        ];
    }

    // Relación con Materia
    public function getMateria()
    {
        // Se conecta con el modelo Materia
        return $this->hasOne(Materia::class, ['id' => 'materiaId']);
    }

    // Relación con Autor (Personal)
    public function getAutor()
    {
        // Se conecta con el modelo Personal
        return $this->hasOne(Personal::class, ['id' => 'autorId']);
    }

    public function getInstitucion()
    {
        return $this->hasOne(Institucion::class, ['id' => 'institucionId']);
    }
}