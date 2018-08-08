<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use esas\hutkigrosh\lang\TranslatorBitrix;
use esas\hutkigrosh\wrappers\ConfigurationWrapper;

require_once('SimpleAutoloader.php');
Loc::loadMessages(__FILE__);

$psTitle = GetMessage("SPCP_DTITLE");
$psDescription = GetMessage("SPCP_DDESCR");

$arPSCorrespondence = array(
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PAYED => createConfigField(ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PAYED, "N"),
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_CANCELED => createConfigField(ConfigurationWrapper::CONFIG_HG_BILL_STATUS_CANCELED, "N"),
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_FAILED => createConfigField(ConfigurationWrapper::CONFIG_HG_BILL_STATUS_FAILED, "N"),
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PENDING => createConfigField(ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PENDING, "N"),
    ConfigurationWrapper::CONFIG_HG_SANDBOX => createConfigField(ConfigurationWrapper::CONFIG_HG_SANDBOX, 1),
    ConfigurationWrapper::CONFIG_HG_ALFACLICK_BUTTON => createConfigField(ConfigurationWrapper::CONFIG_HG_ALFACLICK_BUTTON, 1),
    ConfigurationWrapper::CONFIG_HG_WEBPAY_BUTTON => createConfigField(ConfigurationWrapper::CONFIG_HG_WEBPAY_BUTTON, 1),
    ConfigurationWrapper::CONFIG_HG_EMAIL_NOTIFICATION => createConfigField(ConfigurationWrapper::CONFIG_HG_EMAIL_NOTIFICATION, 0),
    ConfigurationWrapper::CONFIG_HG_SMS_NOTIFICATION => createConfigField(ConfigurationWrapper::CONFIG_HG_SMS_NOTIFICATION, 0),
    ConfigurationWrapper::CONFIG_HG_PASSWORD => createConfigField(ConfigurationWrapper::CONFIG_HG_PASSWORD),
    ConfigurationWrapper::CONFIG_HG_LOGIN => createConfigField(ConfigurationWrapper::CONFIG_HG_LOGIN),
    ConfigurationWrapper::CONFIG_HG_ERIP_ID => createConfigField(ConfigurationWrapper::CONFIG_HG_ERIP_ID)
);
