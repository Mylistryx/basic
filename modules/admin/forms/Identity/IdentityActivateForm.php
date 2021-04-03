<?php

declare(strict_types=1);

namespace app\modules\admin\forms\Identity;

use app\models\Identity;
use app\models\IdentityStatus;
use BadFunctionCallException;
use Yii;
use yii\base\Model;

/**
 * Class IdentityActivateForm
 */
final class IdentityActivateForm extends Model
{
    public ?int $id = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['id', 'required'],
            ['id', 'integer'],
            [
                'id',
                'exist',
                'targetClass' => Identity::class,
                'filter'      => ['current_status' => IdentityStatus::STATUS_INACTIVE],
                'message'     => Yii::t('app', 'Wrong identity status'),
            ],
        ];
    }

    /**
     * @return bool
     */
    public function activate(): bool
    {
        if ($this->validate()) {
            $identity = Identity::findIdentity($this->id);
            $identity->setStatus(IdentityStatus::STATUS_ACTIVE);
            return $identity->save();
        }
        throw new BadFunctionCallException($this->getFirstError('id'));
    }
}