<?php

namespace esas\hutkigrosh\wrappers;

use Bitrix\Main\Config\Option;
use CSalePaySystemAction;
use esas\hutkigrosh\ConfigurationFields;
use esas\hutkigrosh\lang\TranslatorBitrix;

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
        parent::__construct(new TranslatorBitrix());
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
        return $this->getOption(ConfigurationFields::SHOP_NAME);
    }

    /**
     * Имя пользователя для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshLogin()
    {
        return $this->getOption(ConfigurationFields::LOGIN, true);
    }

    /**
     * Пароль для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshPassword()
    {
        return $this->getOption(ConfigurationFields::PASSWORD, true);
    }

    /**
     * Включен ли режим песчоницы
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->checkOn(ConfigurationFields::SANDBOX);
    }

    /**
     * Уникальный идентификатор услуги в ЕРИП
     * @return string
     */
    public function getEripId()
    {
        return $this->getOption(ConfigurationFields::ERIP_ID, true);
    }

    /**
     * Включена ля оповещение клиента по Email
     * @return boolean
     */
    public function isEmailNotification()
    {
        return $this->checkOn(ConfigurationFields::EMAIL_NOTIFICATION);
    }

    /**
     * Включена ля оповещение клиента по Sms
     * @return boolean
     */
    public function isSmsNotification()
    {
        return $this->checkOn(ConfigurationFields::SMS_NOTIFICATION);
    }

    public function getCompletionText()
    {
        return $this->translator->getConfigFieldDefault(ConfigurationFields::COMPLETION_TEXT);
    }

    /**
     * Какой статус присвоить заказу после успешно выставления счета в ЕРИП (на шлюз Хуткигрош_
     * @return string
     */
    public function getBillStatusPending()
    {
        return $this->getOption(ConfigurationFields::BILL_STATUS_PENDING, true);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusPayed()
    {
        return $this->getOption(ConfigurationFields::BILL_STATUS_PAYED, true);
    }

    /**
     * Какой статус присвоить заказу в случаче ошибки выставления счета в ЕРИП
     * @return string
     */
    public function getBillStatusFailed()
    {
        return $this->getOption(ConfigurationFields::BILL_STATUS_FAILED, true);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusCanceled()
    {
        return $this->getOption(ConfigurationFields::BILL_STATUS_CANCELED, true);
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
        return $this->checkOn(ConfigurationFields::ALFACLICK_BUTTON);
    }

    /**
     * Необходимо ли добавлять кнопку "оплатить картой"
     * @return boolean
     */
    public function isWebpayButtonEnabled()
    {
        return $this->checkOn(ConfigurationFields::WEBPAY_BUTTON);
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

    /**
     * Какой срок действия счета после его выставления (в днях)
     * @return string
     */
    public function getDueInterval()
    {
        return $this->getNumeric($this->getOption(ConfigurationFields::DUE_INTERVAL, true), "1");
    }

    /***
     * В некоторых CMS не получается в настройках хранить html, поэтому использует текст итогового экрана по умолчанию,
     * в который проставлятся значение ERIPPATh
     * @return string
     */
    public function getEripPath()
    {
        return $this->getOption(ConfigurationFields::ERIP_PATH, true);
    }
}