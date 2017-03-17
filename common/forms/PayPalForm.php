<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Order;
use webdoka\yiiecommerce\common\models\OrderTransaction;
use webdoka\yiiecommerce\common\models\OrderHistory;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use Yii;

class PayPalForm extends Model
{

    const STATUS_SUCCESS = 'Success';
    const CHECKOUTSTATUS_COMPLETE = 'PaymentActionCompleted';

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
    public function addPaySuccess($uid, $orderid, $payinfo)
    {
        if(Yii::$app->user->id == $uid && $payinfo["ACK"]==self::STATUS_SUCCESS){

            $order=Order::findOne((int)$orderid);

            if($order != null && $order->total == $payinfo["AMT"]){


                if($order->status != Order::STATUS_PAID){

                    $order->status = Order::STATUS_PAID;
                    $order->save();

                    return true;

                }else{
                    return true;
                }

            }


        }
                    return false;
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
            'L_PAYMENTREQUEST_0_QTY0' => '1',
            'order_id' => $this->order_id
        ];

        return ArrayHelper::merge($orderParams, $item);
    }


}
