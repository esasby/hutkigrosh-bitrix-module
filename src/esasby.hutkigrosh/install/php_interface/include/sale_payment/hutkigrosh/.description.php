<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use esas\hutkigrosh\ConfigurationFields;

require_once('SimpleAutoloader.php');
Loc::loadMessages(__FILE__);

$psTitle = GetMessage("SPCP_DTITLE");
$psDescription = GetMessage("SPCP_DDESCR");

$arPSCorrespondence = array(
    ConfigurationFields::DUE_INTERVAL => createConfigField(ConfigurationFields::DUE_INTERVAL, "2"),
    ConfigurationFields::ERIP_PATH => createConfigField(ConfigurationFields::ERIP_PATH, "N"),
    ConfigurationFields::BILL_STATUS_PAYED => createConfigField(ConfigurationFields::BILL_STATUS_PAYED, "N"),
    ConfigurationFields::BILL_STATUS_CANCELED => createConfigField(ConfigurationFields::BILL_STATUS_CANCELED, "N"),
    ConfigurationFields::BILL_STATUS_FAILED => createConfigField(ConfigurationFields::BILL_STATUS_FAILED, "N"),
    ConfigurationFields::BILL_STATUS_PENDING => createConfigField(ConfigurationFields::BILL_STATUS_PENDING, "N"),
    ConfigurationFields::SANDBOX => createConfigField(ConfigurationFields::SANDBOX, 1),
    ConfigurationFields::ALFACLICK_BUTTON => createConfigField(ConfigurationFields::ALFACLICK_BUTTON, 1),
    ConfigurationFields::WEBPAY_BUTTON => createConfigField(ConfigurationFields::WEBPAY_BUTTON, 1),
    ConfigurationFields::EMAIL_NOTIFICATION => createConfigField(ConfigurationFields::EMAIL_NOTIFICATION, 0),
    ConfigurationFields::SMS_NOTIFICATION => createConfigField(ConfigurationFields::SMS_NOTIFICATION, 0),
    ConfigurationFields::PASSWORD => createConfigField(ConfigurationFields::PASSWORD),
    ConfigurationFields::LOGIN => createConfigField(ConfigurationFields::LOGIN),
    ConfigurationFields::ERIP_ID => createConfigField(ConfigurationFields::ERIP_ID)
);
