<?php

$config = [
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '192.168.1.166:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JZOKHyXqDMabQOioUSWG-GuCnKYRS_CX',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class' => 'yii\debug\Module', 'panels' => [
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\DebugPanel',
        ],
    ],
        'allowedIPs'=>["*"]
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;

