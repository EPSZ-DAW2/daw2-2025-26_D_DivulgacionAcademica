<?php

namespace app\models;

use yii\db\ActiveRecord;

class Institucion extends ActiveRecord
{
    public static function tableName()
    {
        return 'institucion'; // Nombre de la tabla 
    }
}