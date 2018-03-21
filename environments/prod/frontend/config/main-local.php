<?php
$config = [
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JZOKHyXqDMabQOioUSWG-GuCnKYRS_CX',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],

            'queue' => [
                'class' => 'mithun\queue\services\RedisQueue',
                // 'config' =>['tcp://10.0.0.1?alias=master', 'tcp://10.0.0.2?alias=slave-01']
                'config' => [
                    'host'   => '127.0.0.1',
                    'port'   => 6379,
                    'database' => 4,
                ],
            ]
        ,
        'session' => [
            'class' => 'yii\redis\Session',
            'cookieParams' => [
                'domain' => '.banhai.com',
                'httpOnly' => true,
            ],
        ],
    ],
];

return $config;