<?php

use yii\web\GroupUrlRule;

return [
    new GroupUrlRule(
        [
            'prefix' => 'admin',
            'rules'  => [
                '' => 'site/index',
            ],
        ]
    ),
];