<?php

declare(strict_types=1);

namespace app\modules\admin;

use yii\base\Module;
use yii\filters\AccessControl;

final class AdminModule extends Module
{
    public $layout = '@app/admin/layouts/main';

    public $behaviors = [
        'AccessControl' => [
            'class' => AccessControl::class,
            'rules' => [
                'allow' => ['admin'],
            ],
        ],
    ];
}