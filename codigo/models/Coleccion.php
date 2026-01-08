<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Este es el modelo para la tabla "coleccion".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $descripcion
 * @property int $usuarioId
 * @property int|null $descargas
 * @property string $fecha_actualizacion
 *
 * @property Usuario $usuario
 */
class Coleccion extends ActiveRecord
{
    /**
     * Define el nombre de la tabla en la DB
     */
    public static function tableName()
    {
        return 'coleccion';
    }

    /**
     * Reglas de validación (basadas en tu estructura SQL)
     */
    public function rules()
    {
        return [
            [['titulo', 'usuarioId'], 'required'],
            [['descripcion'], 'string'],
            [['usuarioId', 'descargas'], 'integer'],
            [['fecha_actualizacion'], 'safe'],
            [['titulo'], 'string', 'max' => 150],
            // Relación de clave foránea con la tabla usuario
            [['usuarioId'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuarioId' => 'id']],
        ];
    }

    /**
     * Etiquetas de los atributos para los formularios y vistas
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título de la Colección',
            'descripcion' => 'Descripción',
            'usuarioId' => 'Autor',
            'descargas' => 'Número de Descargas',
            'fecha_actualizacion' => 'Última Actualización',
        ];
    }

    /**
     * Relación con el modelo Usuario (Muchos a Uno)
     * Permite hacer $coleccion->usuario->nombre
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuarioId']);
    }
}
