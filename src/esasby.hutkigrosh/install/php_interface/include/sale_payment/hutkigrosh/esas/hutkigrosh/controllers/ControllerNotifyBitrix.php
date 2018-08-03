<?php

namespace esas\hutkigrosh\controllers;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:55
 */
use CSaleOrder;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;
use esas\hutkigrosh\wrappers\OrderWrapperBitrix;

class ControllerNotifyBitrix extends ControllerNotify
{
    /**
     * ControllerNotifyModxMinishop2 constructor.
     */
    public function __construct(ConfigurationWrapperBitrix $configurationWrapper)
    {
        parent::__construct($configurationWrapper);
    }


    /**
     * По локальному идентификатору заказа возвращает wrapper
     * @param $orderId
     * @return \esas\hutkigrosh\wrappers\OrderWrapper
     */
    public function getOrderWrapperByOrderNumber($orderNumber)
    {
        // первым делом пытаемся получить заказ по account_number (случай, когда в магазине включен шаблон генерации номер счета)
        $orderByAccount = \Bitrix\Sale\Order::loadByAccountNumber($orderNumber);
        // т.к. нам нужен массив, а не объект \Bitrix\Sale\Order загружаем массив по id.
        // если по account_number заказ не был найден, то пытаемся закгрузить по invId
        $localOrderInfo = CSaleOrder::GetByID(!empty($orderByAccount) ? $orderByAccount->getId() : $orderNumber);
        return empty($order) ? null : new OrderWrapperBitrix($order);
    }
}