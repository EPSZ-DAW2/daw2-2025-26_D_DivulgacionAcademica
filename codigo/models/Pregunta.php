<?php

namespace app\models;

use yii\db\ActiveRecord;

class Pregunta extends ActiveRecord
{
    /**
     * Devuelve el estado en texto legible
     *
     * @return string
     */
    public function getEstadoTexto()
    {
        $mapa = [
            'sin_responder' => 'Sin responder',
            'respondida'    => 'Respondida',
            'resuelta'      => 'Resuelta',
        ];

        return $mapa[$this->estado] ?? $this->estado;
    }

    public static function tableName()
    {
        return 'pregunta';
    }

    public function getRespuestas()
    {
        return $this->hasMany(Respuesta::class, ['preguntaId' => 'id']);
    }

    public function getMateria()
    {
        return $this->hasOne(Materia::class, ['id' => 'materiaId']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuarioId']);
    }

    /**
     * Reglas de validación para el modelo
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'usuarioId'], 'required'], // campos obligatorios
            [['descripcion'], 'string'],
            [['titulo'], 'string', 'max' => 255],
            [['estado'], 'string'],
            [['fecha_creacion'], 'safe'],
            [['materiaId'], 'integer'],
        ];
    }
}

