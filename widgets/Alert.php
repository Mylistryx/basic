<?php

declare(strict_types=1);

namespace app\widgets;

use Yii;
use yii\bootstrap4\Widget;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Alert extends Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public array $alertTypes = [
        'primary'   => 'alert-primary',
        'secondary' => 'alert-secondary',
        'success'   => 'alert-success',
        'danger'    => 'alert-danger',
        'error'     => 'alert-danger',
        'warning'   => 'alert-warning',
        'info'      => 'alert-info',
        'light'     => 'alert-light',
        'dark'      => 'alert-dark',
    ];
    /**
     * @var array the options for rendering the close button tag.
     * Array will be passed to [[\yii\bootstrap4\Alert::closeButton]].
     */
    public array $closeButton = [];


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendClass = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }

            foreach ((array)$flash as $i => $message) {
                echo \yii\bootstrap4\Alert::widget(
                    [
                        'body'        => $message,
                        'closeButton' => $this->closeButton,
                        'options'     => array_merge(
                            $this->options,
                            [
                                'id'    => $this->getId() . '-' . $type . '-' . $i,
                                'class' => $this->alertTypes[$type] . $appendClass,
                            ]
                        ),
                    ]
                );
            }

            $session->removeFlash($type);
        }
    }

    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function primary($message, $removeAfterAccess = true)
    {
        self::addAlert('primary', $message, $removeAfterAccess);
    }


    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function secondary($message, $removeAfterAccess = true)
    {
        self::addAlert('secondary', $message, $removeAfterAccess);
    }


    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function success($message, $removeAfterAccess = true)
    {
        self::addAlert('success', $message, $removeAfterAccess);
    }


    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function danger($message, $removeAfterAccess = true)
    {
        self::addAlert('danger', $message, $removeAfterAccess);
    }

    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function warning($message, $removeAfterAccess = true)
    {
        self::addAlert('warning', $message, $removeAfterAccess);
    }

    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function info($message, $removeAfterAccess = true)
    {
        self::addAlert('info', $message, $removeAfterAccess);
    }

    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function light($message, $removeAfterAccess = true)
    {
        self::addAlert('light', $message, $removeAfterAccess);
    }

    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function dark($message, $removeAfterAccess = true)
    {
        self::addAlert('dark', $message, $removeAfterAccess);
    }

    /**
     * @param string|array $message
     * @param bool $removeAfterAccess
     */
    public static function error($message, $removeAfterAccess = true)
    {
        self::addAlert('error', $message, $removeAfterAccess);
    }

    /**
     * @param $key
     * @param $message
     * @param bool $removeAfterAccess
     */
    private static function addAlert($key, $message, $removeAfterAccess = true)
    {
        Yii::$app->session->addFlash($key, $message, $removeAfterAccess);
    }

}
