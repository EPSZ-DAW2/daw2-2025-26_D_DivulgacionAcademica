<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Documento;
use app\models\Materia;

class MaterialesController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $query = Documento::find();
        
        // Unimos las tablas para poder buscar por sus nombres
        $query->joinWith(['materia', 'autor', 'institucion']);

        // 1. Buscador (Título)
        if ($q = $request->get('q')) {
            $query->andFilterWhere(['like', 'documento.titulo', $q]);
        }

        // 2. Filtro Categoría (Materia)
        if ($categorias = $request->get('category')) {
            $query->andFilterWhere(['in', 'materia.nombre', $categorias]);
        }

        /*
        // 3. Filtro Acceso (Publico/Privado)
        if ($accesos = $request->get('access')) {
            $query->andFilterWhere(['in', 'documento.tipo_acceso', $accesos]);
        }
        
        // 4. Filtro Institución
        if ($instituciones = $request->get('institucion')) {
            $query->andFilterWhere(['in', 'institucion.nombre', $instituciones]);
        }

        // 5. Filtro Autor (Profesor)
        if ($autores = $request->get('autor')) {
            // Busca por nombre O apellido
            $query->andFilterWhere(['or', 
                ['in', 'personal.nombre', $autores],
                ['in', 'personal.apellidos', $autores]
            ]);
        }*/

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 9], 
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}