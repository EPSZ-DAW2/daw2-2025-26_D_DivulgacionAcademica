<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Personal extends ActiveRecord
{
    public static function tableName()
    {
        return 'personal';
    }

    public function rules()
    {
        return [
            [['nombre', 'institucionId'], 'required'],
            [['institucionId'], 'integer'],
            [['nombre', 'apellidos'], 'string', 'max' => 100],
        ];
    }
}