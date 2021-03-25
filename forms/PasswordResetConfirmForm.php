<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Identity;
use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Class PasswordResetConfirmForm
 * @property string $token
 * @property string $password
 * @property-read Identity|null $identity
 */
final class PasswordResetConfirmForm extends Model
{
    public string $token;
    public string $password = '';

    /**
     * PasswordResetConfirmForm constructor.
     * @param string|null $token
     * @param array $config
     */
    public function __construct(?string $token = null, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }

        if (!$this->isPasswordResetTokenValid($token)) {
            throw new InvalidArgumentException('Password reset token is expired.');
        }

        $this->token = $token;

        if (!$this->getIdentity()) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function reset(): bool
    {
        if ($this->validate()) {
            $identity = $this->getIdentity();
            $identity->setPassword($this->password);
            $identity->removePasswordResetToken();
            return $identity->save();
        }
        return false;
    }

    /**
     * @return Identity|null
     */
    public function getIdentity(): ?Identity
    {
        static $identity = false;
        if ($identity === false) {
            $identity = Identity::findByPasswordResetToken($this->token);
        }
        return $identity;
    }

    /**
     * @param string $token
     * @return bool
     */
    private function isPasswordResetTokenValid(string $token): bool
    {
        $parts = explode('_', $token);
        $timestamp = end($parts);
        $timestamp = $timestamp ? (int)$timestamp : 0;
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return is_int($timestamp) && $timestamp + $expire >= time();
    }
}