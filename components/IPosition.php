<?php

namespace webdoka\yiiecommerce\components;

/**
 * Interface IPosition
 * @package webdoka\yiiecommerce\components
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
     * Sets position quantity
     * @return mixed
     */
    public function setQuantity();
}