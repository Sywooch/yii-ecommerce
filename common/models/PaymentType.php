<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\PaymentTypeQuery;

/**
 * This is the model class for table "payment_types".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 *
 * @property Order[] $orders
 */
class PaymentType extends \yii\db\ActiveRecord
{
    const LIST_PAYMENT_TYPE = 'shopListPaymentType';
    const VIEW_PAYMENT_TYPE = 'shopViewPaymentType';
    const CREATE_PAYMENT_TYPE = 'shopCreatePaymentType';
    const UPDATE_PAYMENT_TYPE = 'shopUpdatePaymentType';
    const DELETE_PAYMENT_TYPE = 'shopDeletePaymentType';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'label'], 'required'],
            [['name', 'label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'label' => 'Label',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['payment_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PaymentTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentTypeQuery(get_called_class());
    }
}
