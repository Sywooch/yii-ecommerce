<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\PriceQuery;

/**
 * This is the model class for table "prices".
 *
 * @property integer $id
 * @property string $label
 * @property string $name
 * @property string $auth_item_name
 *
 * @property ProductPrice[] $productsPrices
 */
class Price extends \yii\db\ActiveRecord {

    const LIST_PRICE = 'shopListPrice';
    const VIEW_PRICE = 'shopViewPrice';
    const CREATE_PRICE = 'shopCreatePrice';
    const UPDATE_PRICE = 'shopUpdatePrice';
    const DELETE_PRICE = 'shopDeletePrice';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'prices';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['label', 'name'], 'required'],
            [['label', 'name'], 'string', 'max' => 255],
            [['auth_item_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('shop', 'ID'),
            'label' => Yii::t('shop', 'Label'),
            'name' => Yii::t('shop', 'Name'),
            'auth_item_name' => Yii::t('shop', 'Auth Item Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsPrices() {
        return $this->hasMany(ProductPrice::className(), ['price_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsOptionsPrices() {
        return $this->hasMany(ProductsOptionsPrices::className(), ['price_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PriceQuery the active query used by this AR class.
     */
    public static function find() {
        return new PriceQuery(get_called_class());
    }

    /**
     * Returns min price
     * @param $roles
     * @param $productId
     * @return mixed
     */
    public static function getMinPrice($roles, $productId) {
        return self::find()
                        ->andWhere(['in', 'auth_item_name', $roles])
                        ->andWhere(['pp.product_id' => $productId])
                        ->innerJoinWith('productsPrices pp')
                        ->min('pp.value');
    }

    /**
     * Returns min price
     * @param $roles
     * @param $productId
     * @return mixed
     */
    public static function getOptPrice($roles, $productId, $optid) {
        return self::find()
                        ->andWhere(['in', 'auth_item_name', $roles])
                        ->andWhere(['pop.product_id' => $productId])
                        ->andWhere(['pop.product_options_id' => $optid])
                        ->innerJoinWith('productsOptionsPrices pop')->min('pop.value');
    }

}
