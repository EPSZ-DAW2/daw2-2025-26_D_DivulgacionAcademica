<?php
namespace app\controllers;

use Yii;
use app\models\Documento;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Dompdf\Dompdf;
use Dompdf\Options;

class DocumentoController extends Controller 
{
    public function actionView($id)
    {
        $model = Documento::findOne($id);
        if (!$model) throw new NotFoundHttpException();

        return $this->render('view', ['model' => $model]);
    }

    public function actionDownload($id)
    {
        $model = Documento::findOne($id);
        if (!$model) throw new \yii\web\NotFoundHttpException();

        // Control de acceso para documentos privados
        if ($model->tipo_acceso === 'privado' && Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // Renderizamos una plantilla específica para el documento
        $html = $this->renderPartial('_pdf_documento', ['model' => $model]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return Yii::$app->response->sendContentAsFile(
            $dompdf->output(), 
            $model->archivo_url, 
            ['mimeType' => 'application/pdf']
        );
    }

    
}