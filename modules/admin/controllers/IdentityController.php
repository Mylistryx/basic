<?php

declare(strict_types=1);

namespace app\modules\admin\controllers;

use app\models\Identity;
use app\modules\admin\forms\Identity\IdentityActivateForm;
use app\modules\admin\forms\Identity\IdentityCreateForm;
use app\modules\admin\forms\Identity\IdentityDeleteForm;
use app\modules\admin\forms\Identity\IdentityDisableForm;
use app\modules\admin\forms\Identity\IdentityUpdateForm;
use app\widgets\Alert;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;

class IdentityController extends Controller
{
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Identity::find(),
            ]
        );

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new IdentityCreateForm();
    }

    public function actionUpdate(int $id)
    {
        $model = new IdentityUpdateForm();
    }

    public function actionDelete(int $id)
    {
        $model = new IdentityDeleteForm();
    }

    public function actionDisable(int $id)
    {
        $model = new IdentityDisableForm();
    }

    public function actionActivate(int $id): Response
    {
        $model = new IdentityActivateForm(['id' => $id]);
        try {
            $model->activate();
            Alert::info('Identity activated');
        } catch (\Exception $exception) {
            Alert::danger($exception->getMessage());
        }

        return $this->redirect(['identity/index']);
    }
}