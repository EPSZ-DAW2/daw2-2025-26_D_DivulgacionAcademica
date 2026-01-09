<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Documento extends ActiveRecord
{
    // Variable virtual para la subida del archivo (no se guarda en BD)
    public $archivoFile;

    public static function tableName()
    {
        return 'documento';
    }

    public function rules()
    {
        return [
            [['titulo', 'materiaId', 'institucionId'], 'required'],
            [['materiaId', 'autorId', 'institucionId'], 'integer'],
            [['tipo_acceso'], 'string'],
            // Para el nombre del archivo 
            [['archivo_url'], 'string', 'max' => 255],
            
            // Para subir solo PDFs, obligatorio al crear
            [['archivoFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 10], // Máx 10MB
        ];
    }

    public function attributeLabels()
    {
        return [
            'titulo' => 'Título del Documento',
            'materiaId' => 'Asignatura / Materia',
            'autorId' => 'Autor/a (Profesor/a)',
            'institucionId' => 'Institución',
            'tipo_acceso' => 'Visibilidad',
            'archivoFile' => 'Subir PDF',
        ];
    }

    // Relaciones
    public function getMateria() { return $this->hasOne(Materia::class, ['id' => 'materiaId']); }
    public function getAutor() { return $this->hasOne(Personal::class, ['id' => 'autorId']); }
    public function getInstitucion() { return $this->hasOne(Institucion::class, ['id' => 'institucionId']); }
    
    // Funciones de valoración y comentarios
    public function getComentarios() { return $this->hasMany(DocumentoComentario::class, ['documentoId' => 'id'])->orderBy(['fecha' => SORT_DESC]); }
    public function getValoraciones() { return $this->hasMany(DocumentoValoracion::class, ['documentoId' => 'id']); }
    public function getRatingPromedio() {
        $total = $this->getValoraciones()->count();
        if ($total == 0) return 0;
        return round($this->getValoraciones()->sum('puntuacion') / $total, 1);
    }
    public function getTotalVotos() { return $this->getValoraciones()->count(); }
}