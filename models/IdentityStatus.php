<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;

class IdentityStatus extends Model
{
    public const STATUS_DISABLED = -1;
    public const STATUS_INACTIVE = 10;
    public const STATUS_ACTIVE = 100;
}