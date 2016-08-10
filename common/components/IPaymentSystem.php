<?php

namespace webdoka\yiiecommerce\common\components;

/**
 * Interface IPaymentSystem
 * @package webdoka\yiiecommerce\common\components
 */
interface IPaymentSystem
{
    /**
     * Redirects to payment way
     * @param $invoiceId
     * @return mixed
     */
    public function requestPayment($invoiceId);

    /**
     * Handles result of payment
     * @return mixed
     */
    public function handleResult();

    /**
     * Handles success of payment and show flash
     * @return mixed
     */
    public function handleSuccess();

    /**
     * Handles fail of payment and show flash
     * @return mixed
     */
    public function handleFail();
}