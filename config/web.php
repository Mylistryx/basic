<?php

use app\models\Identity;
use yii\web\UrlManager;
use yii\web\User;

return [
    'id'                  => 'application-web',
    'language'            => 'en',
    'controllerNamespace' => 'app\controllers',
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user'         => [
            'class'           => User::class,
            'identityClass'   => Identity::class,
            'enableAutoLogin' => true,
            'loginUrl'        => ['site/login'],
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'application-web',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'class'           => UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => require 'urlRules.php',
        ],
    ],
];
