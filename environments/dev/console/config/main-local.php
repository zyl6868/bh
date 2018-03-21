<?php
return [
    'bootstrap' => ['gii'],
    'components' => [
        'queue' => [
            'class' => 'mithun\queue\services\RedisQueue',
            // 'config' =>['tcp://10.0.0.1?alias=master', 'tcp://10.0.0.2?alias=slave-01']
            'config' => [
                'host'   => '192.168.1.166',
                'port'   => 6379,
                'database' => 4,
            ],
        ]
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
];
