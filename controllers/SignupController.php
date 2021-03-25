<?php

declare(strict_types=1);

namespace app\controllers;

use app\forms\SignupConfirmForm;
use app\forms\SignupRequestForm;
use app\forms\SignupResendForm;
use app\widgets\Alert;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class SignupController
 */
final class SignupController extends Controller
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
                        'actions' => ['request', 'resend', 'confirm'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionRequest()
    {
        $model = new SignupRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->request()) {
            Alert::info('Check your email for future instructions');
            return $this->goHome();
        }

        return $this->render('request', ['model' => $model]);
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionResend()
    {
        $model = new SignupResendForm();
        if ($model->load(Yii::$app->request->post()) && $model->resend()) {
            Alert::info('Check your email for future instructions');
            return $this->goHome();
        }

        return $this->render('resend', ['model' => $model]);
    }

    /**
     * @param string $token
     * @return Response
     */
    public function actionConfirm(string $token): Response
    {
        try {
            $model = new SignupConfirmForm($token);
            $model->confirm();
            Alert::info('Your account was activated');
        } catch (Exception $exception) {
            Alert::error($exception->getMessage());
        }
        return $this->goHome();
    }
}