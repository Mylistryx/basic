<?php

declare(strict_types=1);

namespace app\models;

use app\traits\IdentityTrait;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class Identity
 * @property int $id
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property int $current_status
 * @property string|null $access_token
 * @property string|null $password_reset_token
 * @property string|null $email_confirmation_token
 * @property-read string $authKey
 * @property-write string $password
 * @property int $status
 */
class Identity extends ActiveRecord implements IdentityInterface
{
    use IdentityTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'TimeStamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * @param string $email
     * @param string $password
     * @return static
     * @throws Exception
     */
    public static function create(string $email, string $password): self
    {
        $identity = new self();
        $identity->email = $email;
        $identity->setPassword($password);
        $identity->generateAuthKey();
        $identity->generateEmailConfirmationToken();
        $identity->save();
        return $identity;
    }
}
