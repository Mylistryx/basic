<?php

declare(strict_types=1);

namespace app\modules\api\controllers;

use yii\rest\Controller;

class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function actionIndex(): array
    {
        return [
            'status' => 'OK',
            'code'   => 200,
        ];
    }
}