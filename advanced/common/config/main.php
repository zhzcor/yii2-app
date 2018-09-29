<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'   => 'zh-CN',
    'components' => [
        // 缓存配置
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        // 数据库配置
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=hongcanglogistic',
            'username' => 'root',
            'password' => 'hongcang123',
            'charset' => 'utf8',
            'tablePrefix' => 'hc_',
        ],

        // 多语言配置
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

        // 日志
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => ['*'],
                ],
            ],
        ],
    ],
];
