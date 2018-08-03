<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 12:38
 */

namespace esas\hutkigrosh\controllers;


use CMain;
use COption;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;
use esas\hutkigrosh\wrappers\OrderWrapper;

class ControllerWebpayFormBitrix extends ControllerWebpayForm
{
    public function __construct(ConfigurationWrapperBitrix $configurationWrapper)
    {
        parent::__construct($configurationWrapper);
    }

    /**
     * Основная часть URL для возврата с формы webpay (чаще всего current_url)
     * @return string
     */
    public function getReturnUrl(OrderWrapper $orderWrapper)
    {
        global $APPLICATION;
        return (CMain::IsHTTPS() ? "https" : "http")
            . "://"
            . ((defined("SITE_SERVER_NAME") && strlen(SITE_SERVER_NAME) > 0) ? SITE_SERVER_NAME : COption::GetOptionString("main", "server_name", "")) . $APPLICATION->GetCurUri();
    }
}