<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl; // Necesario para el control de acceso

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // REGLA 1: Acceso Básico (Perfil + Editarse a sí mismo)
                    [
                        'actions' => ['perfil', 'update'],
                        'allow' => true,
                        'roles' => ['@'], // Usuarios autenticados
                    ],
                    // REGLA 2: Admin Total (Puede hacer todo lo demás: crear, borrar, index)
                    [
                        'actions' => ['index', 'view', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Verifica si el rol es 'admin' usando el modelo Identity
                            return Yii::$app->user->identity->rol === 'admin';
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Muestra el perfil del usuario logueado.
     * (Esta acción fue añadida manualmente)
     */
    public function actionPerfil()
    {
        // 1. Obtener ID del usuario actual
        $userId = Yii::$app->user->id;
        
        // 2. Buscar modelo
        $model = $this->findModel($userId);

        // 3. Renderizar vista
        return $this->render('perfil', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                
                // Lógica de contraseña para CREAR:
                // Si viene 'password_plain', la seteamos.
                if (!empty($model->password_plain)) {
                    $model->setPassword($model->password_plain);
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
 /* public function actionUpdate($id)
{
    $model = $this->findModel($id);
    $model->scenario = 'update';

    if ($this->request->isPost && $model->load($this->request->post())) {
        // Lógica de contraseña del debug
        if (!empty(trim($model->password_plain))) {
            $model->password = trim($model->password_plain);
        } else {
            // Si no hay nueva, recuperamos la vieja para no perderla
            $model->password = $model->getOldAttribute('password');
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', '¡Perfil actualizado!');
            
            // Si soy yo, refresco sesión
            if (Yii::$app->user->id == $model->id) {
                Yii::$app->user->login($model);
                return $this->redirect(['perfil']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
    return $this->render('update', ['model' => $model]);
}*/

public function actionUpdate($id)
{
    $model = $this->findModel($id);
    
    echo "<pre>";
    echo "=== DEBUG UPDATE ===\n";
    echo "Usuario ID: $id\n";
    echo "Es propio perfil: " . (Yii::$app->user->id == $id ? 'Sí' : 'No') . "\n";
    echo "Atributos actuales:\n";
    print_r($model->attributes);
    echo "</pre>";
    
    if ($this->request->isPost) {
        echo "<pre>=== POST RECIBIDO ===\n";
        $post = $this->request->post();
        print_r($post);
        echo "</pre>";
        
        if ($model->load($post)) {
            echo "<pre>=== MODELO CARGADO ===\n";
            echo "Nombre: " . $model->nombre . "\n";
            echo "Email: " . $model->email . "\n";
            echo "Password plain: " . $model->password_plain . "\n";
            echo "</pre>";
            
            // Manejar contraseña
            if (!empty(trim($model->password_plain))) {
                $model->password = trim($model->password_plain);
                echo "<pre>Nueva contraseña establecida: " . $model->password . "</pre>";
            }
            
            // Intentar guardar
            echo "<pre>=== INTENTANDO GUARDAR ===\n";
            if ($model->save()) {
                echo "¡GUARDADO EXITOSO!\n";
                
                // Verificar en BD
                $verificar = $this->findModel($id);
                echo "Verificación BD:\n";
                print_r($verificar->attributes);
                
                echo "<script>alert('¡Guardado exitoso!'); window.location.href='?r=usuario/perfil';</script>";
                return;
            } else {
                echo "ERRORES:\n";
                print_r($model->errors);
                echo "</pre>";
            }
        }
    }
    
    // Mostrar formulario simple
    echo '<form method="post" style="padding: 20px;">';
    echo '<h2>Formulario Debug</h2>';
    echo '<div>Nombre: <input type="text" name="Usuario[nombre]" value="' . htmlspecialchars($model->nombre) . '" style="width: 300px;"></div><br>';
    echo '<div>Email: <input type="text" name="Usuario[email]" value="' . htmlspecialchars($model->email) . '" style="width: 300px;"></div><br>';
    echo '<div>Nueva Contraseña (opcional): <input type="password" name="Usuario[password_plain]" style="width: 300px;"></div><br>';
    echo Yii::$app->request->csrfParam . ': <input type="hidden" name="' . Yii::$app->request->csrfParam . '" value="' . Yii::$app->request->csrfToken . '">';
    echo '<button type="submit">Guardar (Debug)</button>';
    echo '</form>';
    
    exit(); // Salir para ver el debug
}

}
