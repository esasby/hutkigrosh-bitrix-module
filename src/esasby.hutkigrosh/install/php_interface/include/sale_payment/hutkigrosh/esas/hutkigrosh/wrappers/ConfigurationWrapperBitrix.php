<?php

namespace esas\hutkigrosh\wrappers;

use Bitrix\Main\Config\Option;
use CSalePaySystemAction;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 13.03.2018
 * Time: 14:44
 */
class ConfigurationWrapperBitrix extends ConfigurationWrapper
{
    private $params;

    /**
     * ConfigurationWrapperJoomshopping constructor.
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public function __construct()
    {
        parent::__construct();
        //получаем параметры платежной системы
        //может быть есть возможность сделать это как-то более красиво?
        $psId = (int)Option::get('esasby.hutkigrosh', "PAY_SYSTEM_ID");
        $this->params = CSalePaySystemAction::getParamsByConsumer('PAYSYSTEM_' . $psId, null);
    }


    /**
     * Произольно название интернет-мазагина
     * @return string
     */
    public function getShopName()
    {
        return $this->getOption(self::CONFIG_HG_SHOP_NAME);
    }

    /**
     * Имя пользователя для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshLogin()
    {
        return $this->getOption(self::CONFIG_HG_LOGIN, true);
    }

    /**
     * Пароль для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshPassword()
    {
        return $this->getOption(self::CONFIG_HG_PASSWORD, true);
    }

    /**
     * Включен ли режим песчоницы
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->checkOn(self::CONFIG_HG_SANDBOX);
    }

    /**
     * Уникальный идентификатор услуги в ЕРИП
     * @return string
     */
    public function getEripId()
    {
        return $this->getOption(self::CONFIG_HG_ERIP_ID, true);
    }

    /**
     * Включена ля оповещение клиента по Email
     * @return boolean
     */
    public function isEmailNotification()
    {
        return $this->checkOn(self::CONFIG_HG_EMAIL_NOTIFICATION);
    }

    /**
     * Включена ля оповещение клиента по Sms
     * @return boolean
     */
    public function isSmsNotification()
    {
        return $this->checkOn(self::CONFIG_HG_SMS_NOTIFICATION);
    }

    public function getCompletionText()
    {
        return "<p>Счет №<b>@order_number</b> успешно выставлен в ЕРИП.
Вы можете оплатить его наличными деньгами, пластиковой карточкой и электронными деньгами, в любом из отделений банков, кассах, банкоматах, платежных терминалах, в системе электронных денег, через Интернет-банкинг, М-банкинг, интернет-эквайринг
Для оплаты счета в ЕРИП необходимо: </p>
<div class='erip-steps'>
    <ol>
        <li>Выбрать пункт <b>Система 'Расчет' (ЕРИП)</b> </li>
        <li>Выбрать последовательно вкладки: <b>#ERIP_TREE_PATH#</b></li> 
        <li>Ввести номер заказа <b>@order_number</b></li>
        <li>Проверить корректность информации</li>
        <li>Совершить платеж</li>.
    </ol>
</div>";
    }

    /**
     * Какой статус присвоить заказу после успешно выставления счета в ЕРИП (на шлюз Хуткигрош_
     * @return string
     */
    public function getBillStatusPending()
    {
        return $this->getOption(self::CONFIG_HG_BILL_STATUS_PENDING, true);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusPayed()
    {
        return $this->getOption(self::CONFIG_HG_BILL_STATUS_PAYED, true);
    }

    /**
     * Какой статус присвоить заказу в случаче ошибки выставления счета в ЕРИП
     * @return string
     */
    public function getBillStatusFailed()
    {
        return $this->getOption(self::CONFIG_HG_BILL_STATUS_FAILED, true);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusCanceled()
    {
        return $this->getOption(self::CONFIG_HG_BILL_STATUS_CANCELED, true);
    }

    private function checkOn($key)
    {
        $value = $this->getOption($key);
        return $value == '1' || $value == "true";
    }

    /**
     * Описание системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     *
     */
    public function getPaymentMethodDetails()
    {
        // TODO: Implement getPaymentMethodDescription() method.
    }

    /**
     * Необходимо ли добавлять кнопку "выставить в Alfaclick"
     * @return boolean
     */
    public function isAlfaclickButtonEnabled()
    {
        return $this->checkOn(self::CONFIG_HG_ALFACLICK_BUTTON);
    }

    /**
     * Необходимо ли добавлять кнопку "оплатить картой"
     * @return boolean
     */
    public function isWebpayButtonEnabled()
    {
        return $this->checkOn(self::CONFIG_HG_WEBPAY_BUTTON);
    }

    public function getOption($key, bool $warn = false)
    {
        $value = trim(htmlspecialchars($this->params[$key]['VALUE']));
        if ($warn)
            return $this->warnIfEmpty($value, $key);
        else
            return $value;
    }

    /**
     * Название системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public function getPaymentMethodName()
    {
        // TODO: Implement getPaymentMethodName() method.
    }
}