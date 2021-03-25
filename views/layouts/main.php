<?php

/**
 * @var $this View
 * @var $content string
 */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('_menu-top')?>
    <div class="container">
        <?= Breadcrumbs::widget(
            [
                'links' => $this->params['breadcrumbs'] ?? [],
            ]
        ) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer sticky-bottom mt-auto py-3">
    <div class="container">
        <div class="d-flex flex-row justify-content-between">
            <div>&copy; My Company <?php echo date('Y') ?></div>
            <div><?php echo Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
