<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Identity;
use app\models\IdentityStatus;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Class PasswordResetRequestForm
 * @property string $email
 * @property-read Identity|null $identity
 */
final class PasswordResetRequestForm extends Model
{
    public string $email = '';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetClass' => Identity::class,
                'filter'      => ['current_status' => IdentityStatus::STATUS_ACTIVE],
                'message'     => 'There is no active identity with this email address.',
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
            $identity = Identity::findIdentityByEmail($this->email);
            $identity->generatePasswordResetToken();
            return $identity->save() && $this->sendEmail($identity);
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
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['identity' => $identity]
            )
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($identity->email)
            ->send();
    }
}