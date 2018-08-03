<? use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Order;
use esas\hutkigrosh\controllers\ControllerAddBill;
use esas\hutkigrosh\controllers\ControllerWebpayFormBitrix;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;
use esas\hutkigrosh\wrappers\OrderWrapperBitrix;


\Bitrix\Main\Page\Asset::getInstance()->addCss("/bitrix/themes/.default/sale.css");

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

$configurationWrapper = new ConfigurationWrapperBitrix();
$order = Order::load($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"]);
$orderWrapper = new OrderWrapperBitrix($order);
// проверяем, привязан ли к заказу billid, если да,
// то счет не выставляем, а просто прорисовываем старницу
if (empty($orderWrapper->getBillId())) {
    $controller = new ControllerAddBill($configurationWrapper);
    /**
     * @var BillNewRs
     */
    $addBillRs = $controller->process($orderWrapper);
}

$completion_text = $configurationWrapper->cookCompletionText($orderWrapper);
if ($configurationWrapper->isAlfaclickButtonEnabled()) {
    $alfaclick_billID = $orderWrapper->getBillId();
    $alfaclick_phone = $orderWrapper->getMobilePhone();
    $alfaclick_url = "/hutkigrosh/alfaclick.php";
}
if ($configurationWrapper->isWebpayButtonEnabled()) {
    $controller = new ControllerWebpayFormBitrix($configurationWrapper);
    $webpayResp = $controller->process($orderWrapper);
    $webpay_form = $webpayResp->getHtmlForm();
    $webpay_status = $_REQUEST['webpay_status']; // ???
}
include('completion.php');
?>

