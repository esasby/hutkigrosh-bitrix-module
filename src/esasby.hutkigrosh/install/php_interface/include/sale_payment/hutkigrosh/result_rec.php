<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

use Bitrix\Main\Localization\Loc;
use esas\hutkigrosh\controllers\ControllerNotifyBitrix;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;

Loc::loadMessages(__FILE__);

$billId = $_REQUEST['purchaseid'];
$controller = new ControllerNotifyBitrix(new ConfigurationWrapperBitrix());
$controller->process($billId);
die();
?>
