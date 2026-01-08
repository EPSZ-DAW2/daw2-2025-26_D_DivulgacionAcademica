<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Coleccion;
use Yii;

class ColeccionController extends Controller
{
    public function actionIndex()
    {
        // Traemos todas las colecciones con su autor cargado para evitar múltiples consultas
        $colecciones = Coleccion::find()->with('usuario')->all();

        return $this->render('index', [
            'colecciones' => $colecciones,
        ]);
    }
}