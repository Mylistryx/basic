<?php
/**
 * @var $this View
 * @var $identity Identity
 */

use app\models\Identity;
use yii\web\View;

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm', 'token' => $identity->email_confirmation_token]);
?>
Follow the link below to verify your email:
<?= $verifyLink ?>
