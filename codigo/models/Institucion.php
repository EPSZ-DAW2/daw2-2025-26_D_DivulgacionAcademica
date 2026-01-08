<?php

namespace app\models;

use yii\db\ActiveRecord;

class Institucion extends ActiveRecord
{
    public static function tableName()
    {
        // El nombre de la tabla en base de datos es en minúsculas
        return 'institucion';
    }
}