<?php

namespace esas\hutkigrosh\wrappers;

use Bitrix\Sale\Order;
use CSaleBasket;
use CSaleOrder;

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
        return $GLOBALS["SALE_INPUT_PARAMS"]['USER']['NAME'] . ' ' . $GLOBALS["SALE_INPUT_PARAMS"]['USER']['LAST_NAME'];
    }

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getMobilePhone()
    {
        return $GLOBALS["SALE_INPUT_PARAMS"]['PROPERTY']['PHONE'];
    }

    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getEmail()
    {
        return $GLOBALS["SALE_INPUT_PARAMS"]['PROPERTY']['EMAIL'];
    }

    /**
     * Физический адрес покупателя
     * @return string
     */
    public function getAddress()
    {
        return $GLOBALS["SALE_INPUT_PARAMS"]['PROPERTY']['CITY'] . ' ' . $GLOBALS["SALE_INPUT_PARAMS"]['PROPERTY']['ADDRESS'];
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
        //выберем все товары из корзины
        $arBasketItems = array();
        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => $this->getOrderId()
            ),
            false,
            false,
            array("ID",
                "NAME",
                "CALLBACK_FUNC",
                "MODULE",
                "PRODUCT_ID",
                "QUANTITY",
                "DELAY",
                "CAN_BUY",
                "PRICE",
                "CURRENCY",
                "WEIGHT")
        );
        //TODO WTF?
        while ($arItems = $dbBasketItems->Fetch()) {
            if (strlen($arItems["CALLBACK_FUNC"]) > 0) {
                CSaleBasket::UpdatePrice($arItems["ID"],
                    $arItems["CALLBACK_FUNC"],
                    $arItems["MODULE"],
                    $arItems["PRODUCT_ID"],
                    $arItems["QUANTITY"]);
                $arItems = CSaleBasket::GetByID($arItems["ID"]);
            }
            $arBasketItems[] = $arItems;
        }


        if (is_array($arBasketItems)) {
            foreach ($arBasketItems as $line_item)
                $this->products[] = new OrderProductWrapperBitrix($line_item);
        }
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
        //TODO
//        return $this->order->get('status');
    }

    /**
     * Обновляет статус заказа в БД
     * @param $newStatus
     * @return mixed
     */
    public function updateStatus($newStatus)
    {
        CSaleOrder::Update($this->getOrderId(), array("STATUS_ID" => $newStatus));
    }

    /**
     * Сохраняет привязку billid к заказу
     * @param $billId
     * @return mixed
     */
    public function saveBillId($billId)
    {
        CSaleOrder::Update($this->getOrderId(), array("COMMENTS" => $billId));
    }
}