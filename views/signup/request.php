<?php
/**
 * @var $this View
 * @var $form ActiveForm
 * @var $model SignupRequestForm
 */

use app\forms\SignupRequestForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

$this->title = Yii::t('form.signup', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('form.signup', 'Signup now'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
