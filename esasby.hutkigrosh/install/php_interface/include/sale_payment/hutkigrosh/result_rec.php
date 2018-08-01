<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

use Esas\HootkiGrosh\HGConfig;
use Esas\HootkiGrosh\HootkiGrosh;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

include_once 'hutkigrosh_api.php';
$purchaseid = $_REQUEST['purchaseid'];
if (!isset($purchaseid)) {
    throw new Exception('Wrong purchaseid');
}

$config = new HGConfig();
$config->password = CSalePaySystemAction::GetParamValue("PWD");
$config->login = CSalePaySystemAction::GetParamValue("LOGIN");
$config->sandbox = CSalePaySystemAction::GetParamValue("SANDBOX");


#дополнительно проверим статус счета в hg
$hg = new HootkiGrosh($config);
$hgBillInfo = $hg->apiBillInfo($purchaseid);
if (empty($hgBillInfo)) {
    $error = $hg->getError();
    $hg->apiLogOut(); // Завершаем сеанс
    throw new Exception($error);
} else {
    $hg->apiLogOut();
    // первым делом пытаемся получить заказ по account_number (случай, когда в магазине включен шаблон генерации номер счета)
    $orderByAccount = \Bitrix\Sale\Order::loadByAccountNumber($hgBillInfo['invId']);
    // т.к. нам нужен массив, а не объект \Bitrix\Sale\Order загружаем массив по id.
    // если по account_number заказ не был найден, то пытаемся закгрузить по invId
    $localOrderInfo = CSaleOrder::GetByID(!empty($orderByAccount) ? $orderByAccount->getId() : $hgBillInfo['invId']);
    if ($localOrderInfo['USER_NAME'] . ' ' . $localOrderInfo['USER_LAST_NAME'] != $hgBillInfo['fullName']
        && $localOrderInfo['PRICE'] != $hgBillInfo['amt']) {
        throw new Exception("Unmapped purchaseid");
    }
    if ($localOrderInfo["PAYED"] == "Y")
        echo "Status already changed";
    elseif ($hgBillInfo["statusEnum"] != "Payed")
        echo "Bill is not payed!";
    elseif ($localOrderInfo["ID"] > 0) {
        CSaleOrder::PayOrder($localOrderInfo["ID"], "Y");
        $fields = array("STATUS_ID" => "P",
            "PAYED" => "Y"
        );
        CSaleOrder::Update($localOrderInfo["ID"], $fields);
        echo "OK";
    } else
        echo "ERROR";
}

die();
?>
