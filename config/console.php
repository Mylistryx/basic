<?php

use app\models\Identity;
use yii\console\controllers\FixtureController;
use yii\web\User;

return [
    'id'                  => 'application-console',
    'controllerNamespace' => 'app\console',
    'components'          => [
        'user' => [
            'class'           => User::class,
            'identityClass'   => Identity::class,
            'enableAutoLogin' => false,
            'loginUrl'        => false,
        ],
    ],
    'controllerMap'       => [
        'fixture' => [
            'class'     => FixtureController::class,
            'namespace' => 'app\fixtures',
        ],
    ],
];
