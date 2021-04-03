<?php

declare(strict_types=1);

namespace app\modules\api;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\Response;

final class ApiModule extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class'   => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
//                    'application/xml'  => Response::FORMAT_XML,
                ],
            ],
            'authenticator'     => [
                'class'       => CompositeAuth::class,
                'authMethods' => [
                    HttpBasicAuth::class,
                    HttpBearerAuth::class,
                    QueryParamAuth::class,
                ],
            ],
        ];
    }

    /**
     * ApiModule constructor.
     * @param $id
     * @param Application|null $parent
     * @param array $config
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $config = ArrayHelper::merge(
            $config,
            require __DIR__ . '/config/moduleConfig.php'

        );
        parent::__construct($id, $parent, $config);
    }

    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@apiModule', __DIR__);
        $urlManager = $app->getUrlManager();
        $urlManager->addRules(require __DIR__ . '/config/urlManager.php');
    }
}