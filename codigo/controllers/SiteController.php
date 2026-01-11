<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistroUsuarios; // Necesario para el formulario de registro
use app\models\Pregunta;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'logs'], // Añadido 'logs' al control de acceso si deseas protegerlo
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // Puedes descomentar esto para que solo usuarios logueados vean los logs
                    /*
                    [
                        'actions' => ['logs'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    */
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Enseña la pagina index
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Accion de inicio de sesion.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            // --->>> MODIFICACIÓN LOGS <<<---
            // Registramos que el usuario ha iniciado sesión correctamente
            \app\models\UserLog::add('Login Success');
            // -------------------------------

            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Accion de cierre de sesion.
     *
     * @return Response
     */
    public function actionLogout()
    {
        // --->>> MODIFICACIÓN LOGS <<<---
        // Registramos que el usuario va a cerrar sesión (antes de que se cierre)
        \app\models\UserLog::add('Logout');
        // -------------------------------

        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Muestra la pagina de contacto.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Muestra la pagina de sobre mi .
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Acción para registrar un nuevo usuario (Register).
     *
     * @return mixed
     */
    public function actionRegister()
    {
        $model = new RegistroUsuarios();

        // Si se reciben datos por POST y el registro es exitoso
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            
            // Mensaje flash para informar al usuario
            Yii::$app->session->setFlash('success', 'Gracias por registrarte. Ahora puedes iniciar sesión.');
            
            // Redirigir al inicio (o al login si prefieres)
            return $this->goHome();
        }

        // Si no se enviaron datos o hubo error, mostramos la vista de registro
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Acción para visualizar el registro de actividad (User Logs).
     *
     * @return string
     */
    public function actionLogs()
    {
        // Opcional: Proteger esta ruta para que solo usuarios logueados (o admins) la vean
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        // Preparamos los datos para el GridView usando el modelo UserLog
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \app\models\UserLog::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('logs', [
            'dataProvider' => $dataProvider,
        ]);
    }
    }
