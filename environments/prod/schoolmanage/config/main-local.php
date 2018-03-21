<?php
$config = [
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JZOKHyXqDMabQOioUSWG-GuCnKYRS_CX',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'session' => [
            'class' => 'yii\redis\Session',
        ],
    ],
];

return $config;