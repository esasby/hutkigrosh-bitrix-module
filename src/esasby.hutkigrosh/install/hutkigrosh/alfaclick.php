<?php
//подключаем только служебную часть пролога (для работы с CModule и CSalePaySystemAction), без визуальной части, чтобы не было вывода ненужного html
use esas\hutkigrosh\controllers\ControllerAlfaclick;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/sale_payment/hutkigrosh/SimpleAutoloader.php");

if (!CModule::IncludeModule("sale")) return;

$controller = new ControllerAlfaclick(new ConfigurationWrapperBitrix());
$controller->process($_REQUEST['billid'], $_REQUEST['phone']);
