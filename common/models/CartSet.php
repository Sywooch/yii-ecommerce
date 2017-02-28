<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\CartSetQuery;

/**
 * This is the model class for table "carts_sets".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $set_id
 *
 * @property CartProduct[] $cartsProducts
 * @property Set $set
 * @property Cart $carts
 */
class CartSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carts_sets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_id', 'set_id'], 'required'],
            [['cart_id', 'set_id'], 'integer'],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => Set::className(), 'targetAttribute' => ['set_id' => 'id']],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'cart_id' => Yii::t('shop', 'Cart ID'),
            'set_id' => Yii::t('shop', 'Set ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartsProducts()
    {
        return $this->hasMany(CartProduct::className(), ['cart_set_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSet()
    {
        return $this->hasOne(Set::className(), ['id' => 'set_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }

    /**
     * @inheritdoc
     * @return CartSetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CartSetQuery(get_called_class());
    }
}
