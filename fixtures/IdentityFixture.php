<?php

namespace app\fixtures;

use app\models\Identity;
use yii\test\ActiveFixture;

class IdentityFixture extends ActiveFixture
{
    public $modelClass = Identity::class;
    public $data = '@tests\_data\Identity.php';
}