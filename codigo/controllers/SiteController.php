<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistroUsuarios;
use app\models\Documento; // Importante

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'logs'],
                'rules' => [
                    ['actions' => ['logout'], 'allow' => true, 'roles' => ['@']],
                    ['actions' => ['logs'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['logout' => ['post']],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
            'captcha' => ['class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null],
        ];
    }

    // --- ACCIÓN PRINCIPAL DE LA PORTADA ---
    public function actionIndex()
    {
        // 1. Documentos recientes
        $recientes = Documento::find()
            ->orderBy(['id' => SORT_DESC])
            ->limit(3)
            ->with(['materia', 'autor'])
            ->all();

        // 2. Estadísticas (Calculadas directamente de la BD)
        $db = Yii::$app->db;
        $stats = [
            'materiales' => (int) $db->createCommand("SELECT COUNT(*) FROM documento")->queryScalar(),
            'estudiantes' => (int) $db->createCommand("SELECT COUNT(*) FROM usuario WHERE rol='alumno'")->queryScalar(),
            'colaboradores' => (int) $db->createCommand("SELECT COUNT(*) FROM personal")->queryScalar(),
            'descargas' => (int) $db->createCommand("SELECT SUM(descargas) FROM coleccion")->queryScalar()
        ];

        return $this->render('index', [
            'recientes' => $recientes,
            'stats' => $stats
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) return $this->goHome();
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            \app\models\UserLog::add('Login Success');
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        \app\models\UserLog::add('Logout');
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new RegistroUsuarios();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Gracias por registrarte.');
            return $this->goHome();
        }
        return $this->render('register', ['model' => $model]);
    }
    
    public function actionLogs()
    {
        if (Yii::$app->user->isGuest) return $this->redirect(['site/login']);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \app\models\UserLog::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('logs', ['dataProvider' => $dataProvider]);
    }
}