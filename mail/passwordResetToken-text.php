<?php
/**
 * @var $this View
 * @var $identity Identity
 */

use app\models\Identity;
use yii\web\View;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['password-reset/reset', 'token' => $identity->password_reset_token]);
?>
Follow the link below to reset your password:
<?= $resetLink ?>
