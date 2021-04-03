<?php

/**
 * @var View $this
 * @var DataProviderInterface $dataProvider
 */

use yii\data\DataProviderInterface;
use yii\grid\GridView;
use yii\web\View;

echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
    ]
);