<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Identity;
use app\models\IdentityStatus;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Class SignupConfirmForm
 * @property string $token
 * @property-read null|Identity $identity
 */
final class SignupConfirmForm extends Model
{
    public string $token;

    /**
     * PasswordResetConfirmForm constructor.
     * @param string $token
     * @param array $config
     */
    public function __construct(string $token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Email confirmation token cannot be blank.');
        }

        $this->token = $token;

        if (!$this->getIdentity()) {
            throw new InvalidArgumentException('Wrong email confirmation token.');
        }
        parent::__construct($config);
    }

    /**
     * @return bool
     */
    public function confirm(): bool
    {
        $identity = $this->getIdentity();
        $identity->status = IdentityStatus::STATUS_ACTIVE;
        $identity->removeEmailConfirmationToken();
        return $identity->save();
    }

    /**
     * @return Identity|null
     */
    public function getIdentity(): ?Identity
    {
        static $identity = false;
        if ($identity === false) {
            $identity = Identity::findByEmailConfirmationToken($this->token);
        }
        return $identity;
    }
}