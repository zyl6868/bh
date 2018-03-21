<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '192.168.1.166',
            'port' => 6379,
            'database' => 0,
        ],

        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '192.168.1.166:9201'],
                // configure more hosts if you have a cluster
            ],
        ],
        'db' => require(__DIR__ . '/db_local.php'),
        'db_school' => require(__DIR__ . '/db_school_local.php'),
        'db_sanku' => require(__DIR__ . '/db_sanku_local.php'),
        'db_schoo_lmanage' => require(__DIR__ . '/db_school_manage_local.php'),
        'db_databusiness' => require(__DIR__ . '/db_databusiness_local.php'),
        'db_he_edu' => require(__DIR__ . '/db_he_edu_local.php'),

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
