<?php
//
//return
//    [
//        'class' => 'yii\db\Connection',
//
//        // configuration for the master
//        'dsn' => 'mysql:host=127.0.0.1;dbname=teachresource;charset=utf8',
//        'username' => 'root',
//        'password' => 'root',
//
//        // common configuration for slaves
//        'slaveConfig' => [
//            'username' => 'root',
//            'password' => 'root',
//            'attributes' => [
//                // use a smaller connection timeout
//                PDO::ATTR_TIMEOUT => 10,
//            ],
//        ],
//
//        // list of slave configurations
//        'slaves' => [
//            ['dsn' => 'mysql:host=127.0.0.1;dbname=teachresource;charset=utf8'],
//        ],
//    ];


return
    [
        'class' => 'yii\db\Connection',
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 3600,
        'schemaCache' => 'cache',

        // configuration for the master
        'dsn' => 'mysql:host=192.168.1.225;port=8066;dbname=teachresource;charset=utf8',
        'username' => 'admin',
        'password' => 'neptune@admin'
    ];