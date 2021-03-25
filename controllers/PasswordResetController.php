<?php

declare(strict_types=1);

namespace app\controllers;

use app\forms\PasswordResetConfirmForm;
use app\forms\PasswordResetRequestForm;
use app\widgets\Alert;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class PasswordController
 */
final class PasswordResetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['request', 'reset'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionRequest()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->request()) {
            Alert::info('Please check your email for future instructions');
            return $this->goHome();
        }

        return $this->render('request', ['model' => $model]);
    }

    /**
     * @param string|null $token
     * @return string|Response
     * @throws Exception
     */
    public function actionReset(?string $token = null)
    {
        try {
            $model = new PasswordResetConfirmForm($token);
            if ($model->load(Yii::$app->request->post()) && $model->reset()) {
                Alert::info('Your password was changed');
                return $this->redirect(['auth/login']);
            }
            return $this->render('reset', ['model' => $model]);
        } catch (\Exception $exception) {
            Alert::error($exception->getMessage());
            return $this->goHome();
        }
    }
}