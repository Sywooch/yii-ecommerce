<?php

namespace webdoka\yiiecommerce\common\components;

/**
 * Interface ISetPosition
 * @package webdoka\yiiecommerce\common\components
 */
interface ISetPosition
{
    /**
     * Returns position id
     * @return integer
     */
    public function getId();

    /**
     * Returns position name
     * @return string
     */
    public function getName();

    /**
     * Returns position real price
     * @return float
     */
    public function getRealPrice();

    /**
     * Returns position quantity
     * @return mixed
     */
    public function getQuantity();

    /**
     * Sets quantity
     * @param $quantity
     * @return mixed
     */
    public function setQuantity($quantity);
}