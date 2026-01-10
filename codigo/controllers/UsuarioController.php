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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // 1. Activamos escenario 'update' para exigir 'current_password'
        $model->scenario = 'update'; 

        $esAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'admin';
        $esPropioPerfil = !Yii::$app->user->isGuest && Yii::$app->user->id == $id;

        if (!$esAdmin && !$esPropioPerfil) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para editar este perfil.');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            
            // Si NO es admin, restauramos el rol original
            if (!$esAdmin) {
                $model->rol = $model->getOldAttribute('rol'); 
            }

            // Si hay nueva contraseña, la seteamos
            if (!empty($model->password_plain)) {
                $model->setPassword($model->password_plain);
            }

            // Guardamos (esto validará current_password automáticamente)
            if ($model->save()) {
                
                // 2. FIX LOGOUT: Refrescamos la sesión si es el propio usuario
                if ($esPropioPerfil) {
                    Yii::$app->user->login($model, 3600 * 24 * 30); 
                    return $this->redirect(['perfil']);
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


}
