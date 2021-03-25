<?php

use yii\web\GroupUrlRule;

return [
    new GroupUrlRule(
        [
            'prefix' => 'auth',
            'rules'  => [
                ''            => 'login',
                'POST logout' => 'logout',
            ],
        ]
    ),
    new GroupUrlRule(
        [
            'prefix' => 'signup',
            'rules'  => [
                ''        => 'request',
                'resend'  => 'resend',
                'confirm' => 'confirm',
            ],
        ]
    ),
    new GroupUrlRule(
        [
            'prefix' => 'password-reset',
            'rules'  => [
                ''      => 'request',
                'reset' => 'reset',
            ],
        ]
    ),
];