<?php

namespace webdoka\yiiecommerce\common\components;

/**
 * Interface IPosition
 * @package webdoka\yiiecommerce\common\components
 */
interface IPosition
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
     * Returns position price
     * @return float
     */
    public function getPrice();

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