<?php

namespace webdoka\yiiecommerce\common\models;

use app\models\Profile;
use Yii;

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
            'id' => 'ID',
            'profile_id' => 'Profile',
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
     * Returns Products
     * @return $this
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('cartProducts');
    }

    /**
     * Returns profile
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
