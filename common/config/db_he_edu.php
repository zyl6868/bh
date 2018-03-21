<?php

return
[
    'class' => 'yii\db\Connection',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',

    // configuration for the master
    'dsn' => 'mysql:host=192.168.1.24;port=8066;dbname=sh_he_edu;charset=utf8',
    'username' => 'phpuser',
    'password' => 'neptune@admin'
];