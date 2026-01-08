<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Personal extends ActiveRecord
{
    public static function tableName()
    {
        return 'personal'; // Nombre de la tabla 
    }
}