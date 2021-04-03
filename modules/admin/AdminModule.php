<?php

declare(strict_types=1);

namespace app\modules\admin;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

final class AdminModule extends Module implements BootstrapInterface
{
//    public $layout = '@adminModule/views/layouts/main';

    public function __construct($id, $parent = null, $config = [])
    {
        $config = ArrayHelper::merge($config, require __DIR__ . '/config/moduleConfig.php');
        parent::__construct($id, $parent, $config);
    }

    public function behaviors(): array
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function bootstrap($app)
    {
        Yii::setAlias('@adminModule', __DIR__);
        $urlManager = $app->getUrlManager();
        $urlManager->addRules(require __DIR__ . '/config/urlRules.php');
    }
}