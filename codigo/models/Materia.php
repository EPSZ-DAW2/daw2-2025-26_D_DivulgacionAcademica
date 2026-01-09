<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Materia extends ActiveRecord
{
    public static function tableName()
    {
        return 'materia';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['parentId'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
        ];
    }
}