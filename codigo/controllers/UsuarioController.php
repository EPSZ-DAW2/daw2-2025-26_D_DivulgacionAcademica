<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsuarioController implementa las acciones del CRUD de usuario
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
                        'roles' => ['@'],
                    ],
                    // REGLA 2: Admin Total
                    [
                        'actions' => ['index', 'view', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
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
     * Lista todos los usuarios
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
     * Muestra un usuario específico
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Muestra el perfil del usuario logueado
     */
    public function actionPerfil()
    {
        $userId = Yii::$app->user->id;
        $model = $this->findModel($userId);

        return $this->render('perfil', [
            'model' => $model,
        ]);
    }

    /**
     * Crea un nuevo usuario
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Usuario creado correctamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Actualiza un usuario existente
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Si no es admin, solo puede editar su propio ID
        if (Yii::$app->user->identity->rol !== 'admin' && Yii::$app->user->id != $id) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para editar este perfil.');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Tus datos han sido actualizados con éxito.');

                // Redirección
                if (Yii::$app->user->id == $id) {
                    return $this->redirect(['perfil']);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Elimina un usuario
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Usuario eliminado correctamente.');

        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo basado en ID
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}