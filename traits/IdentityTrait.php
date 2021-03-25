<?php

declare(strict_types=1);

namespace app\traits;

use app\models\Identity;
use app\models\IdentityStatus;
use Yii;
use yii\base\Exception;

trait IdentityTrait
{
    /**
     * @param int|string $id
     * @return static|null
     */
    public static function findIdentity($id): ?self
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        return static::findOne(['access_token' => $token, 'current_status' => IdentityStatus::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail(string $email): ?self
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param string $token
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token): ?self
    {
        return static::findOne(
            [
                'password_reset_token' => $token,
                'current_status'               => IdentityStatus::STATUS_ACTIVE,
            ]
        );
    }

    /**
     * @param string $token
     * @return static|null
     */
    public static function findByEmailConfirmationToken(string $token): ?self
    {
        return Identity::findOne(['email_confirmation_token' => $token, 'current_status' => IdentityStatus::STATUS_INACTIVE]);
    }

    /**
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @throws Exception
     */
    public function generateEmailConfirmationToken(): void
    {
        $this->email_confirmation_token = Yii::$app->security->generateRandomString();
    }

    /**
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * No return
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    /**
     * No return
     */
    public function removeEmailConfirmationToken(): void
    {
        $this->email_confirmation_token = null;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->current_status = $status;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->current_status;
    }

    /**
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}