<?php

use esas\hutkigrosh\lang\TranslatorBitrix;

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

Logger::configure(array(
    'rootLogger' => array(
        'appenders' => array('fileAppender'),
        'level' => 'INFO',
    ),
    'appenders' => array(
        'fileAppender' => array(
            'class' => 'LoggerAppenderFile',
            'layout' => array(
                'class' => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '%date{Y-m-d H:i:s,u} | %logger{0} | %-5level | %msg %n%throwable',
                )
            ),
            'params' => array(
                'file' => $_SERVER["DOCUMENT_ROOT"] . '/hutkigrosh.log',
                'append' => true
            )
        )
    )
));

function createConfigField($key, $defaultValue = null)
{
    return array(
        "NAME" => TranslatorBitrix::translate($key),
        "DESCR" => TranslatorBitrix::translate($key . "_desc"),
        "VALUE" => $defaultValue != null ? $defaultValue : "",
        "TYPE" => ""
    );
}