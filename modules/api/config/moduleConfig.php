<?php

declare(strict_types=1);

use app\models\Identity;
use yii\web\JsonParser;
use yii\web\JsonResponseFormatter;
use yii\web\Request;
use yii\web\Response;
use yii\web\User;
use yii\web\XmlResponseFormatter;

return [
    'components' => [
        'request'  => [
            'class'                  => Request::class,
            'parsers'                => [
                'application/json' => JsonParser::class,
                'application/xml'  => XMLParser::class,
            ],
            'enableCookieValidation' => false,
        ],
        'response' => [
            'class'      => Response::class,
            'format'     => Response::FORMAT_JSON,
            'charset'    => 'UTF-8',
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class'         => JsonResponseFormatter::class,
                    'prettyPrint'   => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
                Response::FORMAT_XML  => [
                    'class'    => XmlResponseFormatter::class,
                    'encoding' => 'UTF-8',
                ],
            ],
        ],
        'user'     => [
            'class'           => User::class,
            'identityClass'   => Identity::class,
            'enableAutoLogin' => false,
            'enableSession'   => false,
            'loginUrl'        => false,
        ],
    ],
];