<?php
namespace schoolmanage\controllers;


use Exception;
use schoolmanage\models\LoginForm;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @var string
     */
    public $layout = 'lay_login_site';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'page', 'captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'page' => [
                'class' => 'yii\web\ViewAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => '5',
                'minLength' => '5',
            ]
        ];

    }

    public function actionIndex()
    {
        return $this->redirect(['/exam/default/index']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            \Yii::info('用户登录，userId：'.Yii::$app->user->id . ',方法：' . __METHOD__  , 'userHandler');
            return $this->redirect(['/exam/default/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $this->layout = 'main';
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }
        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultName ?: Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }
        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {

            if (false) {
                return $this->render('localerror', ['name' => $name, 'message' => $message, 'exception' => $exception]);
            } else {
                return $this->render('error', ['name' => $name, 'message' => $message, 'exception' => $exception]);
            }

//            return $this->controller->render($this->view ?: $this->id, [
//                'name' => $name,
//                'message' => $message,
//                'exception' => $exception,
//            ]);


        }
    }


}
