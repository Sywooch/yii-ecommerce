<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $quantity
 *
 * @property Product $order
 * @property Order $order0
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => false, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => false, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
