<?php
/**
 * @var $this View
 * @var $identity Identity
 */

use app\models\Identity;
use yii\bootstrap4\Html;
use yii\web\View;

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm', 'token' => $identity->email_confirmation_token]);
?>
<div class="verify-email">
    <p>Follow the link below to verify your email:</p>
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
