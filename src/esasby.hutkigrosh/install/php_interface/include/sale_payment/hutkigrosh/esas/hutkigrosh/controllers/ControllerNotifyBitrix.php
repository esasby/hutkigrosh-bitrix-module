<?php

namespace esas\hutkigrosh\controllers;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:55
 */
use Bitrix\Sale\Order;
use CSaleOrder;
use esas\hutkigrosh\lang\TranslatorBitrix;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;
use esas\hutkigrosh\wrappers\OrderWrapperBitrix;

class ControllerNotifyBitrix extends ControllerNotify
{
    /**
     * ControllerNotifyModxMinishop2 constructor.
     */
    public function __construct(ConfigurationWrapperBitrix $configurationWrapper)
    {
        parent::__construct($configurationWrapper, new TranslatorBitrix());
    }


    /**
     * По локальному идентификатору заказа возвращает wrapper
     * @param $orderNumber
     * @return \esas\hutkigrosh\wrappers\OrderWrapper
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public function getOrderWrapperByOrderNumber($orderNumber)
    {
        // первым делом пытаемся получить заказ по account_number (случай, когда в магазине включен шаблон генерации номер счета)
        $orderByAccount = Order::loadByAccountNumber($orderNumber);
        if ($orderByAccount == null)
            $orderByAccount = Order::load($orderNumber);
        return new OrderWrapperBitrix($orderByAccount);
    }

    public function onStatusPayed()
    {
        parent::onStatusPayed();
        CSaleOrder::Update($this->localOrderWrapper->getOrderId(), array("PAYED" => "Y"));
        CSaleOrder::PayOrder($this->localOrderWrapper->getOrderId(), "Y");
    }

}