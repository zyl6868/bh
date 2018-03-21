<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [

    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [

        'admin' => [
            'class' => 'mdm\admin\Module',
            // 'layout'=>'left-menu'
        ],
        'posweb' => [
            'class' => 'backend\modules\posweb\Module',
        ]

        ,
        'jf' => [
            'class' => 'backend\modules\jf\Module',
        ]

        ,
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //‘enableStrictParsing‘ => false,
            'suffix' => '.htm',
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
            //   'defaultRoles' => ['guest'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'yii\bootstrap\BootstrapAsset' => false,

            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [

            'site/login',
            'site/logout',
            'site/error',
            'gii/*',
            'debug/*'
        ]
        ,
    ],
    'params' => $params,
];
