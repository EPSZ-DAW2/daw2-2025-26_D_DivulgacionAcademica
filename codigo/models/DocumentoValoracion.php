<?php

namespace app\models;

use Yii;

class DocumentoValoracion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'documento_valoracion';
    }

    public function rules()
    {
        return [
            [['usuarioId', 'documentoId', 'puntuacion'], 'required'],
            [['usuarioId', 'documentoId', 'puntuacion'], 'integer'],
            [['puntuacion'], 'integer', 'min' => 1, 'max' => 5],
            [['fecha'], 'safe'],
        ];
    }
}