<?php
use common\components\ZipkinConfService;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php'),
   require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'on beforeRequest' => function ($event) {
        ZipkinConfService::init('banhai-console');
    },
    'on afterRequest' => function ($event) {
        ZipkinConfService::allEnd();
    },

    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
