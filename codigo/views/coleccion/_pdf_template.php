<?php
/** @var app\models\Coleccion $model */
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #1f2937; line-height: 1.5; }
        .header { border-bottom: 3px solid #2563eb; padding-bottom: 20px; margin-bottom: 30px; }
        .title { color: #2563eb; font-size: 28px; font-weight: bold; margin: 0; }
        .author { color: #6b7280; font-size: 14px; margin-top: 5px; }
        .description { background: #f9fafb; padding: 15px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #d1d5db; }
        .section-header { font-size: 18px; font-weight: bold; color: #111827; margin-bottom: 15px; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; }
        .doc-list { list-style: none; padding: 0; }
        .doc-item { padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
        .doc-title { font-weight: bold; font-size: 16px; color: #1f2937; }
        .doc-meta { font-size: 12px; color: #6b7280; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title"><?= mb_strtoupper($model->titulo) ?></h1>
        <div class="author">
            Colección creada por: <strong><?= $model->usuario->nombre ?></strong> | 
            Fecha de exportación: <?= date('d/m/2026') ?>
        </div>
    </div>

    <div class="section-header">Descripción</div>
    <div class="description">
        <?= nl2br($model->descripcion) ?>
    </div>

    <div class="section-header">Materiales incluidos en esta colección</div>
    <div class="doc-list">
        <?php foreach ($model->documentos as $index => $doc): ?>
            <div class="doc-item">
                <div class="doc-title"><?= ($index + 1) . ". " . $doc->titulo ?></div>
                <div class="doc-meta">
                    Acceso: <?= $doc->tipo_acceso ?> | 
                    Referencia de archivo: <?= $doc->archivo_url ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="footer">
        Portal de Divulgación Académica - Documento generado automáticamente - 2026
    </div>
</body>
</html>