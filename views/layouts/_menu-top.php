<?php
/**
 * @var View $this
 */

use app\widgets\LanguageDropdown;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\web\View;

?>
<?php NavBar::begin(
    [
        'brandLabel' => Yii::$app->name,
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => ['navbar-dark', 'bg-dark', 'navbar-expand-md', 'fixed-top'],
        ],
    ]
); ?>
<?= Nav::widget(
    [
        'options' => ['class' => ['navbar-nav', 'ml-auto']],
        'items'   => [
            ['label' => Yii::t('app.menu', 'Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('app.menu', 'About'), 'url' => ['/site/about']],
            ['label' => Yii::t('app.menu', 'Contact'), 'url' => ['/site/contact']],
            /* [
                'label' => Yii::t('app.menu', 'Language'),
                'items' => LanguageDropdown::widget(),
            ], */
            ['label' => Yii::t('app.menu', 'Signup'), 'url' => ['/signup/request'], 'visible' => Yii::$app->user->isGuest],
            ['label' => Yii::t('app.menu', 'Login'), 'url' => ['/auth/login'], 'visible' => Yii::$app->user->isGuest],
            [
                'label'   => Yii::t('app.menu', 'Settings'),
                'visible' => !Yii::$app->user->isGuest,
                'items'   => [
                    [
                        'label' => Yii::t('app.menu', 'Profile'),
                        'url'   => ['/site/profile'],
                    ],
                ],
            ],
            [
                'label'       => Yii::t(
                    'app.menu',
                    'Logout ({username})',
                    [
                        'username' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->email,
                    ]
                ),
                'visible'     => !Yii::$app->user->isGuest,
                'url'         => ['/auth/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ],
        ],
    ]
); ?>
<?php NavBar::end(); ?>