<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Documento extends ActiveRecord
{
    public $archivoFile;

    public static function tableName()
    {
        return 'documento';
    }

    public function rules()
    {
        return [
            [['titulo', 'materiaId', 'institucionId'], 'required'],
            [['materiaId', 'autorId', 'institucionId', 'usuario_subida_id'], 'integer'],
            [['tipo_acceso'], 'string'],
            [['archivo_url'], 'string', 'max' => 255],
            
            // --- CAMBIO AQUÍ: AÑADIMOS EXTENSIONES Y SUBIMOS TAMAÑO ---
            [['archivoFile'], 'file', 
                'skipOnEmpty' => false, 
                'extensions' => 'pdf, doc, docx, xls, xlsx, ppt, pptx, mp4', // Word, Excel, PowerPoint, Video
                'maxSize' => 1024 * 1024 * 50 // Límite subido a 50MB para los vídeos
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'titulo' => 'Título del Documento',
            'materiaId' => 'Asignatura / Materia',
            'autorId' => 'Autor Original (Profesor)',
            'institucionId' => 'Institución',
            'tipo_acceso' => 'Visibilidad',
            'archivoFile' => 'Archivo',
        ];
    }

    // --- Relaciones ---
    public function getMateria() { return $this->hasOne(Materia::class, ['id' => 'materiaId']); }
    public function getAutor() { return $this->hasOne(Personal::class, ['id' => 'autorId']); }
    public function getInstitucion() { return $this->hasOne(Institucion::class, ['id' => 'institucionId']); }
    
    // Funciones extra
    public function getComentarios() { return $this->hasMany(DocumentoComentario::class, ['documentoId' => 'id'])->orderBy(['fecha' => SORT_DESC]); }
    public function getValoraciones() { return $this->hasMany(DocumentoValoracion::class, ['documentoId' => 'id']); }
    public function getRatingPromedio() {
        $total = $this->getValoraciones()->count();
        if ($total == 0) return 0;
        return round($this->getValoraciones()->sum('puntuacion') / $total, 1);
    }
    public function getTotalVotos() { return $this->getValoraciones()->count(); }
}