<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}