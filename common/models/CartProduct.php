<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\CartProductQuery;

/**
 * This is the model class for table "carts_products".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $cart_set_id
 *
 * @property Product $product
 * @property Cart $cart
 */
class CartProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carts_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id'], 'required'],
            [['cart_id', 'product_id', 'quantity', 'cart_set_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop','ID'),
            'cart_id' => Yii::t('shop','Cart ID'),
            'product_id' => Yii::t('shop','Product ID'),
            'quantity' => Yii::t('shop','Quantity'),
            'cart_set_id' => Yii::t('shop','Set'),
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
    public function getCart()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }

    /**
     * @return CartProductQuery
     */
    public static function find()
    {
        return new CartProductQuery(get_called_class());
    }
}
