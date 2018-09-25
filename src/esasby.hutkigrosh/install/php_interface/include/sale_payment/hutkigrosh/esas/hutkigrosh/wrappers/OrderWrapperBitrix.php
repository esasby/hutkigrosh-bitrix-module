<?php

namespace esas\hutkigrosh\wrappers;

use Bitrix\Sale\Order;
use CSaleOrder;
use esas\hutkigrosh\lang\TranslatorBitrix;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 13.03.2018
 * Time: 14:51
 */
class OrderWrapperBitrix extends OrderWrapper
{
    private $order;
    private $products;

    /**
     * OrderWrapperJoomshopping constructor.
     * @param $order
     */
    public function __construct(Order $order)
    {
        parent::__construct(new TranslatorBitrix());
        $this->order = $order;
    }

    /**
     * Уникальный номер заказ в рамках CMS
     * @return string
     */
    public function getOrderId()
    {
        return $this->order->getId();
    }

    public function getOrderNumber()
    {
        // если включен шаблон генерации номера заказа, то подставляем этот номер
        $accountNumber = $this->order->getField('ACCOUNT_NUMBER');
        return !empty($accountNumber) ? $accountNumber : $this->getOrderId();
    }

    /**
     * Полное имя покупателя
     * @return string
     */
    public function getFullName()
    {
        return $this->order->getPropertyCollection()->getPayerName()->getValue();
    }

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->order->getPropertyCollection()->getPhone()->getValue();
    }

    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getEmail()
    {
        return $this->order->getPropertyCollection()->getUserEmail()->getValue();
    }

    /**
     * Физический адрес покупателя
     * @return string
     */
    public function getAddress()
    {
        $address = $this->order->getPropertyCollection()->getAddress();
        if ($address == null)
            $address = $this->order->getPropertyCollection()->getDeliveryLocation();
        if ($address != null)
            $address->getValue();
        else
            return "";
    }

    /**
     * Общая сумма товаров в заказе
     * @return string
     */
    public function getAmount()
    {
        return $this->order->getPrice();
    }

    /**
     * Валюта заказа (буквенный код)
     * @return string
     */
    public function getCurrency()
    {
//        $orderCurrency = isset($orderCurrency) ? $orderCurrency : $line_item['CURRENCY']; //TODO со временем можно сделать выставление разных счетов,
        return $this->order->getCurrency();
    }

    /**
     * Массив товаров в заказе
     * @return \esas\hutkigrosh\wrappers\OrderProductWrapper[]
     */
    public function getProducts()
    {
        if ($this->products != null)
            return $this->products;
        $basket = $this->order->getBasket();
        foreach ($basket->getOrderableItems() as $basketItem)
            $this->products[] = new OrderProductWrapperBitrix($basketItem);
        return $this->products;
    }

    /**
     * BillId (идентификатор хуткигрош) успешно выставленного счета
     * @return mixed
     */
    public function getBillId()
    {
        return $this->order->getField("COMMENTS");
    }

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     */
    public function getStatus()
    {
        return $this->order->getField("STATUS_ID");
    }

    /**
     * Обновляет статус заказа в БД
     * @param $newStatus
     * @return mixed
     * @throws \Bitrix\Main\ArgumentException
     */
    public function updateStatus($newStatus)
    {
        if (!empty($newStatus) && $this->getStatus() != $newStatus) {
            CSaleOrder::Update($this->getOrderId(), array("STATUS_ID" => $newStatus));
            $this->order->setField("STATUS_ID", $newStatus);
        }
    }

    /**
     * Сохраняет привязку billid к заказу
     * @param $billId
     * @return mixed
     * @throws \Bitrix\Main\ArgumentException
     */
    public function saveBillId($billId)
    {
        CSaleOrder::Update($this->getOrderId(), array("COMMENTS" => $billId));
        $this->order->setField("COMMENTS", $billId);
    }
}