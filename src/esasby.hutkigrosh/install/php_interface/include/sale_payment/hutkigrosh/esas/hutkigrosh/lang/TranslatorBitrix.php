<?php

namespace esas\hutkigrosh\lang;

use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 10.07.2018
 * Time: 11:45
 */
class TranslatorBitrix
{
    private static $locale = null;

    public static function translate($msg)
    {
        if (null === self::$locale) {
            $context = Context::getCurrent();
            if ($context !== null) {
                self::$locale = $context->getLanguage() . "_" . strtoupper($context->getLanguage());
            } else {
                self::$locale = "ru_RU";
            }
        }
        return Translator::translate($msg, self::$locale);
    }
}