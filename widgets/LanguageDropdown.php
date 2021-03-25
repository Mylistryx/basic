<?php

declare(strict_types=1);

namespace app\widgets;

use codemix\localeurls\UrlManager;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap4\Dropdown;

class LanguageDropdown extends Dropdown
{
    private static array $labels = [];

    private bool $isError;

    public function init()
    {
        $route = Yii::$app->controller->route;
        $appLanguage = Yii::$app->language;
        $params = $_GET;
        $this->isError = $route === Yii::$app->errorHandler->errorAction;

        array_unshift($params, '/' . $route);

        /** @var UrlManager $urlManager */
        $urlManager = Yii::$app->urlManager;
        foreach ($urlManager->languages as $language) {
            $isWildcard = substr($language, -2) === '-*';
            if (
                $language === $appLanguage || $isWildcard && substr($appLanguage, 0, 2) === substr($language, 0, 2)
            ) {
                continue;   // Exclude the current language
            }
            if ($isWildcard) {
                $language = substr($language, 0, 2);
            }
            $params['language'] = $language;
            $this->items[] = [
                'label' => self::label($language),
                'url'   => $params,
            ];
        }
        parent::init();
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function run(): string
    {
        // Only show this widget if we're not on the error page
        if ($this->isError) {
            return '';
        } else {
            return parent::run();
        }
    }

    /**
     * @param string $code
     * @return string|null
     */
    public static function label(string $code): ?string
    {
        if (self::$labels === []) {
            self::$labels = [
                'en' => Yii::t('app.language', 'English'),
                'ru' => Yii::t('app.language', 'Russian'),
            ];
        }

        return self::$labels[$code] ?? null;
    }
}