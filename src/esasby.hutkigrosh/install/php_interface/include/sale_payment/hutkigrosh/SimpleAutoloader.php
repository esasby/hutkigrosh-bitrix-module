<?php

use esas\hutkigrosh\lang\TranslatorBitrix;
use esas\hutkigrosh\utils\LoggerDefault;

require_once(dirname(__FILE__) . '/vendor/autoload.php');

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.06.2018
 * Time: 16:18
 */
class SimpleAutoloader
{
    static public function loader($class)
    {
        $className = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        $path = dirname(__FILE__) . '/' . $className . '.php';
        if (file_exists($path)) {
            require_once($path);
            if (class_exists($class)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

spl_autoload_register('SimpleAutoloader::loader');

LoggerDefault::init();

// функция перенесена из .description.php, т.к. при объявлении ее там возникает Exception (PHP Fatal error: Cannot redeclare)
function createConfigField($key, $defaultValue = null)
{
    $translator = new TranslatorBitrix();
    return array(
        "NAME" => $translator->getConfigFieldName($key),
        "DESCR" => $translator->getConfigFieldDescription($key),
        "VALUE" => $defaultValue != null ? $defaultValue : $translator->getConfigFieldDefault($key),
        "TYPE" => ""
    );
}