<?php
/**
 * @var $this View
 * @var $identity Identity
 */

use app\models\Identity;
use yii\bootstrap4\Html;
use yii\web\View;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['password-reset/reset', 'token' => $identity->password_reset_token]);
?>
<div class="password-reset">
    <p>Follow the link below to reset your password:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
