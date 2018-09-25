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
class TranslatorBitrix extends TranslatorImpl
{
    private $locale = null;

    public function getLocale()
    {
        if (null === $this->locale) {
            $context = Context::getCurrent();
            if ($context !== null) {
                $this->locale = $context->getLanguage() . "_" . strtoupper($context->getLanguage());
            } else {
                $this->locale = "ru_RU";
            }
        }
    }
}