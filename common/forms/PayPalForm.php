<?php

namespace webdoka\yiiecommerce\common\forms;


use yii\helpers\ArrayHelper;
use yii\base\Model;
use Yii;

class PayPalForm extends Model
{

    public $name;
    public $summ;
    public $currency;
    public $description;
    public $quantity;
    public $order_id;


    public function rules()
    {
        return [
            [['name', 'summ', 'currency', 'description'], 'required'],
            [['summ', 'quantity', 'order_id'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'summ' => 'Sum',
            'currency' => 'Currency',
            'description' => 'Description',

        ];
    }

    /**
     * @inheritdoc
     */
    public function getRequest()
    {

        $orderParams = [
            'PAYMENTREQUEST_0_AMT' => $this->summ,
            'PAYMENTREQUEST_0_CURRENCYCODE' => $this->currency,
            'PAYMENTREQUEST_0_ITEMAMT' => $this->summ
        ];

        $item = [
            'L_PAYMENTREQUEST_0_NAME0' => $this->name,
            'L_PAYMENTREQUEST_0_DESC0' => $this->description,
            'L_PAYMENTREQUEST_0_AMT0' => $this->summ,
            'L_PAYMENTREQUEST_0_QTY0' => isset($this->quantity) ? $this->quantity : '1',
            'order_id' => $this->order_id
        ];

        return ArrayHelper::merge($orderParams, $item);
    }


}
