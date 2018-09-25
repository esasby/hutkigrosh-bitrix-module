<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

use Bitrix\Main\Localization\Loc;
use esas\hutkigrosh\controllers\ControllerNotifyBitrix;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;

Loc::loadMessages(__FILE__);

try {
    $billId = $_REQUEST['purchaseid'];
    $controller = new ControllerNotifyBitrix(new ConfigurationWrapperBitrix());
    $controller->process($billId);
} catch (Throwable $e) {
    \esas\hutkigrosh\utils\Logger::getLogger("result")->error("Exception:", $e);
}
die();
?>
