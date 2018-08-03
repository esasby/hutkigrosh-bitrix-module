<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 14.03.2018
 * Time: 17:08
 */

namespace esas\hutkigrosh\wrappers;

class OrderProductWrapperBitrix extends OrderProductWrapper
{
    private $product;

    /**
     * OrderProductWrapperJoomshopping constructor.
     * @param $product
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Артикул товара
     * @return string
     */
    public function getInvId()
    {
        return $this->product['ID'];
    }

    /**
     * Название или краткое описание товара
     * @return string
     */
    public function getName()
    {
        return $this->product['NAME'];
    }

    /**
     * Количество товароа в корзине
     * @return mixed
     */
    public function getCount()
    {
        return round($this->product['QUANTITY']);
    }

    /**
     * Цена за единицу товара
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->product['QUANTITY'] * $this->product['PRICE'];
    }
}