<?php

use yii\caching\FileCache;
use yii\db\Connection;
use yii\log\FileTarget;
use yii\swiftmailer\Mailer;

$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'basePath'   => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'components' => [
        'cache'  => [
            'class' => FileCache::class,
        ],
        'db'     => [
            'class'    => Connection::class,
            'dsn'      => 'mysql:host=127.0.0.1;dbname=yii2basic',
            'username' => 'root',
            'password' => 'root',
            'charset'  => 'utf8mb4',
        ],
        'i18n'   => require __DIR__ . '/i18n.php',
        'log'    => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class'            => Mailer::class,
            'viewPath'         => '@app/mail',
            'useFileTransport' => true,
        ],
    ],
    'params'     => $params,
];
