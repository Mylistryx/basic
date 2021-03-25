<?php

return [
    'id'         => 'application-test',
    'components' => [
        'assetManager' => [
            'basePath' => dirname(__DIR__) . '/web/assets',
        ],
        'urlManager'   => [
            'showScriptName'  => true,
            'enablePrettyUrl' => false,
        ],
        'request'      => [
            'cookieValidationKey' => 'test',
            'csrfParam'           => '_csrf-test',
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'application-test',
        ],
        'user'         => [
            'identityCookie' => ['name' => '_identity-test', 'httpOnly' => true],
        ],
    ],
];
