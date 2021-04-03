<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Identity;
use Yii;
use yii\base\Exception;
use yii\base\Model;

final class SignupRequestForm extends Model
{
    public string $email = '';
    public string $password = '';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', 'trim'],
            [['email', 'password'], 'required'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => Identity::class,
                'message'     => 'Current email address is already taken.',
            ],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function request(): bool
    {
        if ($this->validate()) {
            return (($identity = Identity::create($this->email, $this->password)) !== null && $this->sendEmail($identity));
        }
        return false;
    }

    /**
     * @param Identity $identity
     * @return bool
     */
    private function sendEmail(Identity $identity): bool
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['identity' => $identity]
            )
            ->setSubject('Confirm your email on ' . Yii::$app->name)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($identity->email)
            ->send();
    }
}