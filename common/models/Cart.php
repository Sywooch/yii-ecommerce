<?php

namespace webdoka\yiiecommerce\common\models;

use app\models\Profile;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $profile_id
 *
 * @property CartProduct[] $cartProducts
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['profile_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop','ID'),
            'profile_id' => Yii::t('shop','Profile'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartProducts()
    {
        return $this->hasMany(CartProduct::className(), ['cart_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartProductsNoSet()
    {
        return $this->hasMany(CartProduct::className(), ['cart_id' => 'id'])->noSet();
    }

    /**
     * Returns Products
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('cartProducts');
    }

    /**
     * @return $this
     */
    public function getProductsNoSet()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('cartProductsNoSet');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartSets()
    {
        return $this->hasMany(CartSet::className(), ['cart_id' => 'id']);
    }

    /**
     * Returns Sets
     * @return $this
     */
    public function getSets()
    {
        return $this->hasMany(Set::className(), ['id' => 'set_id'])->via('cartSets');
    }

    /**
     * Returns profile
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
