<?php
use common\clients\UserLoginService;
use common\components\ZipkinConfService;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'mobileWeb',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'name' => '班海',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'mobileWeb\controllers',

    'on beforeRequest' => function ($event) {
        ZipkinConfService::init('banhai-mobile');
    },
    'on afterRequest' => function ($event) {
        ZipkinConfService::allEnd();
    },


    'modules' => [
        'courseware' => [
            'class' => 'mobileWeb\modules\api\modules\courseware\CoursewareModule',
        ],
        'homework' => [
            'class' => 'mobileWeb\modules\api\modules\homework\HomeworkModule'
        ],
        'keywords' => [
            'class' => 'mobileWeb\modules\api\modules\keywords\KeywordsModule'
        ],
        'web' => [
            'class' => 'mobileWeb\modules\web\WebModule'
        ],


    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'BT4m8fV50CAJpaSuawoUWrbuqIa_Ppdg',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'mobileWeb\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'on afterLogin' =>
                function ($event) {
                    $token = Yii::$app->request->get('token');

                    setcookie("token",$token,60);
                },
        ],
        'urlManager' => [
            'enablePrettyUrl' => YII_ENV == 'test' ? false : true,
            'showScriptName' => YII_ENV == 'test' ? true : false,
            //  'suffix' => '.htm',

            'rules' => YII_ENV == 'test' ? [] : [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+(-\w+)*>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+(-\w+)*>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+(-\w+)*>' => '<module>/<controller>/<action>',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'system' =>
                    [
                        'class' => 'yii\log\FileTarget',
                        'levels' => ['error', 'warning'],
                    ],
                'message' =>
                    [
                        'class' => 'yii\log\FileTarget',
                        'logVars' => [],
                        'levels' => ['info'],
                        'categories' => ['message'],
                        'logFile' => '@app/runtime/logs/message'.date('Ymd').'.log',
                    ],

            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'yii\bootstrap\BootstrapAsset' => false,

            ],
        ],
    ],
    'params' => $params,
];
