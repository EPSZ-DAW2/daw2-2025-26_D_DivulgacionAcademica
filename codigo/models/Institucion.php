<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Institucion extends ActiveRecord
{
    public static function tableName()
    {
        return 'institucion';
    }

    public function rules()
    {
        return [
            [['nombre', 'tipo'], 'required'],
            [['tipo'], 'string'],
            [['nombre'], 'string', 'max' => 150],
            [['ubicacion'], 'string', 'max' => 255],
            [['contacto'], 'string', 'max' => 100],
        ];
    }
}