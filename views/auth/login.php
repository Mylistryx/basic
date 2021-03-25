<?php
/**
 * @var $this View
 * @var $form ActiveForm
 * @var $model LoginForm
 */

use app\forms\LoginForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

$this->title = Yii::t('form.login', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('form.login', 'Please fill out the following fields to login:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                If you forgot your password you can <?= Html::a('reset it', ['password-reset/request']) ?>.
                <br>
                Need new verification email? <?= Html::a('Resend', ['signup/resend']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('form.login', 'Login now'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
