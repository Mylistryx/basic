<?php

use yii\db\Connection;
use yii\swiftmailer\Mailer;

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'db'      => [
            'class'    => Connection::class,
            'dsn'      => 'mysql:host=127.0.0.1;dbname=yii2basic',
            'username' => 'root',
            'password' => 'root',
            'charset'  => 'utf8mb4',
        ],
        'mailer'  => [
            'class'            => Mailer::class,
            'viewPath'         => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
    ];
}

return $config;
