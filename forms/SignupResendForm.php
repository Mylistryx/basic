<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Identity;
use app\models\IdentityStatus;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Class SignupResendForm
 * @property string $email
 * @property-read null|Identity $identity
 */
final class SignupResendForm extends Model
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
            [
                'email',
                'exist',
                'targetClass' => Identity::class,
                'filter'      => ['current_status' => IdentityStatus::STATUS_INACTIVE],
                'message'     => 'There is no inactive user with this email address.',
            ],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function resend(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $identity = $this->getIdentity();
        $identity->generateEmailConfirmationToken();
        return $identity->save() && $this->sendEmail($identity);
    }

    /**
     * @return Identity|null
     */
    public function getIdentity(): ?Identity
    {
        static $identity = false;
        if ($identity === false) {
            $identity = Identity::findByEmail($this->email);
        }
        return $identity;
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