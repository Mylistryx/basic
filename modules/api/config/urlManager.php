<?php

use yii\web\GroupUrlRule;

return [
    new GroupUrlRule(
        [
            'prefix' => 'api',
            'rules'  => [
                '' => 'site/index',
            ],
        ]
    ),
];