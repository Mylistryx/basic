<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Identity;
use app\models\IdentityStatus;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property string $email
 * @property string $password
 * @property bool $rememberMe
 * @property-read Identity|null $identity This property is read-only.
 */
final class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    public bool $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
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
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword(string $attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getIdentity();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getIdentity(), $this->rememberMe ? Yii::$app->params['user.RememberMeTimeout'] : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
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
}
