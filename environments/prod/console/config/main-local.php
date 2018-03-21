<?php
return [
    'components' => [
        'queue' => [
            'class' => 'mithun\queue\services\RedisQueue',
            // 'config' =>['tcp://10.0.0.1?alias=master', 'tcp://10.0.0.2?alias=slave-01']
            'config' => [
                'host'   => '127.0.0.1',
                'port'   => 6379,
                'database' => 4,

            ],
        ]
    ],
];
