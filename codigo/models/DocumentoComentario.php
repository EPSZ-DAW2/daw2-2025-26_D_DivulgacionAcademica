<?php

namespace app\models;

use Yii;

class DocumentoComentario extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'documento_comentario';
    }

    public function rules()
    {
        return [
            [['contenido', 'usuarioId', 'documentoId'], 'required'],
            [['contenido'], 'string'],
            [['usuarioId', 'documentoId'], 'integer'],
            [['fecha'], 'safe'],
        ];
    }

    // Un comentario pertenece a un Usuario
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuarioId']);
    }
}