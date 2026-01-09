<?php
/** @var app\models\Documento $model */
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; padding: 40px; color: #1f2937; line-height: 1.6; }
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 20px; margin-bottom: 40px; }
        .institution { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .title { font-size: 26px; font-weight: bold; color: #1e3a8a; margin: 0; }
        .author-line { font-size: 14px; margin-top: 10px; color: #374151; }
        .content { margin-top: 50px; }
        .content h3 { color: #1e3a8a; border-left: 4px solid #2563eb; padding-left: 15px; }
        .footer { position: fixed; bottom: 30px; left: 0; right: 0; font-size: 10px; color: #9ca3af; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .badge { display: inline-block; padding: 2px 10px; border-radius: 4px; background: #f3f4f6; font-size: 12px; color: #4b5563; }
    </style>
</head>
<body>
    <div class="header">
        <div class="institution"><?= $model->institucion ? $model->institucion->nombre : 'Portal de Divulgación Académica' ?></div>
        <h1 class="title"><?= $model->titulo ?></h1>
        <div class="author-line">
            Autor: <strong><?= $model->autor ? $model->autor->nombre . ' ' . $model->autor->apellidos : 'Autor no especificado' ?></strong>
        </div>
    </div>

    <div class="content">
        <h3>Resumen del Recurso Académico</h3>
        <p>Este archivo es una representación digital del documento original registrado en nuestra plataforma. 
        Ha sido clasificado bajo la materia de <strong><?= $model->materia ? $model->materia->nombre : 'General' ?></strong>.</p>
        
        <p>Este material es de acceso <strong><?= strtoupper($model->tipo_acceso) ?></strong>. Se recuerda que la reproducción total o parcial de este contenido 
        debe citar debidamente a la institución emisora y a sus autores originales.</p>
        
        <div style="margin-top: 30px;">
            <span class="badge">Referencia: <?= $model->archivo_url ?></span>
        </div>
    </div>

    <div class="footer">
        Documento generado automáticamente el <?= date('d/m/Y H:i') ?> - Sistema de Divulgación Académica
    </div>
</body>
</html>