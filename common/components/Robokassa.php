<?php

namespace webdoka\yiiecommerce\common\components;

use Yii;
use webdoka\yiiecommerce\common\models\Invoice;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class Robokassa extends Component implements IPaymentSystem
{

    const URL = 'https://merchant.roboxchange.com/Index.aspx';

    public
        $shopId = false,
        $password1 = false,
        $password2 = false,
        $testPassword1 = false,
        $testPassword2 = false,
        $isTest = true;

    public function requestPayment($invoiceId)
    {
        if (!$invoice = Invoice::find()->where(['id' => $invoiceId])->one()) {
            throw new InvalidParamException('Invalid $invoiceId.');
        }

        if ($invoice->status != Invoice::PENDING_STATUS) {
            throw new BadRequestHttpException(Yii::t('shop', 'The account has already been processed previously.'));
        }

        $merchant = $this->shopId;
        $amount = $invoice->amount;
        $currency = $invoice->account->currency->abbr;
        $description = $invoice->description;
        $password = $this->isTest ? $this->testPassword1 : $this->password1;
        $shopItem = 1;

        $crc = md5(implode(':', [$merchant, $amount, $invoice->id, $currency, $password, 'Shp_item=' . $shopItem]));
        $crc = strtoupper($crc);

        return Yii::$app->view->render('@webdoka/common/components/views/robokassa.php', [
            'action' => self::URL,
            'merchant' => $merchant,
            'amount' => $amount,
            'currency' => $currency,
            'description' => $description,
            'invoiceId' => $invoice->id,
            'crc' => $crc,
            'shopItem' => $shopItem,
            'isTest' => intval($this->isTest)
        ]);
    }

    public function handleResult()
    {
        $amount = Yii::$app->request->post('OutSum');
        $invoiceId = Yii::$app->request->post('InvId');
        $shopItem = Yii::$app->request->post('Shp_item');
        $crc = strtoupper(Yii::$app->request->post('SignatureValue'));
        $password = $this->isTest ? $this->testPassword2 : $this->password2;

        $ownCrc = strtoupper(md5(implode(':', [$amount, $invoiceId, $password, 'Shp_item=' . $shopItem])));

        if ($crc != $ownCrc) {
            die('BAD SIGN');
        }

        if (!$invoice = Invoice::find()->where(['id' => $invoiceId])->pending()->one()) {
            die('INVALID INV_ID');
        }

        if (!Yii::$app->billing->changeInvoice($invoice->id, Invoice::SUCCESS_STATUS)) {
            die('UNABLE TO CHANGE INVOICE');
        }

        die('OK');
    }

    public function handleSuccess()
    {
        $invoiceId = Yii::$app->request->post('InvId');

        // Check invoice
        if ($invoice = Invoice::find()->where(['id' => $invoiceId])->success()->one()) {
            Yii::$app->session->addFlash('order_success', 'Order #' . $invoice->order->id . ' has been paid successfully.');
        } else {
            Yii::$app->session->addFlash('order_failure', 'Invoice #' . $invoiceId . ' not found. Please contact our technical support.');
        }
    }

    public function handleFail()
    {
        $invoiceId = Yii::$app->request->post('InvId');

        // Check invoice
        if ($invoice = Invoice::find()->where(['id' => $invoiceId])->pending()->one()) {
            if (Yii::$app->billing->changeInvoice($invoice, Invoice::FAIL_STATUS)) {
                Yii::$app->session->addFlash('order_failure', 'Invoice #' . $invoiceId . ' payment has been declined.');
            } else {
                Yii::$app->session->addFlash('order_failure', 'Unable to decline invoice #' . $invoiceId . '.');
            }
        } else {
            Yii::$app->session->addFlash('order_failure', 'Invoice #' . $invoiceId . ' not found. Please contact our technical support.');
        }
    }

}
