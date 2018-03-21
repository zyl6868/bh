<?php

return
    [
        'class' => 'yii\db\Connection',
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 3600,
        'schemaCache' => 'cache',

        // configuration for the master
        'dsn' => 'mysql:host=192.168.1.24;dbname=pos_admin_test;charset=utf8',
        'username' => 'admin',
        'password' => 'neptune@admin',

        // common configuration for slaves
        'slaveConfig' => [
            'username' => 'admin',
            'password' => 'neptune@admin',
            'attributes' => [
                // use a smaller connection timeout
                PDO::ATTR_TIMEOUT => 10,
            ],
        ],

        // list of slave configurations
        'slaves' => [
            ['dsn' => 'mysql:host=192.168.1.40;dbname=pos_admin_test;charset=utf8'],
            ['dsn' => 'mysql:host=192.168.1.41;dbname=pos_admin_test;charset=utf8'],
            ['dsn' => 'mysql:host=192.168.1.42;dbname=pos_admin_test;charset=utf8'],
        ],
    ];
