<?php

// comment out the following two lines when deployed to production
use yii\helpers\ArrayHelper;
use yii\web\Application;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../config/bootstrap.php';

$config = ArrayHelper::merge(
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php',
    require __DIR__ . '/../config/web.php',
    require __DIR__ . '/../config/web-local.php',
);

(new Application($config))->run();
