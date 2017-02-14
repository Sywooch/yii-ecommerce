<?php

namespace webdoka\yiiecommerce\common\models;
use creocoder\nestedsets\NestedSetsQueryBehavior;

use Yii;

/**
 * This is the model class for table "products_options_prices".
 *
 * @property integer $id
 * @property integer $product_options_id
 * @property integer $price_id
 * @property double $value
 *
 * @property Prices $price
 * @property ProductsOptions $productOptions
 */
class ProductsOptionsPrices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_options_prices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_options_id', 'price_id'], 'required'],
            [['product_options_id', 'price_id'], 'integer'],
            [['value'], 'number'],
            [['price_id'], 'exist', 'skipOnError' => true, 'targetClass' => Price::className(), 'targetAttribute' => ['price_id' => 'id']],
            [['product_options_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsOptions::className(), 'targetAttribute' => ['product_options_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_options_id' => 'Product Options ID',
            'price_id' => 'Price ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Prices::className(), ['id' => 'price_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductOptions()
    {
        return $this->hasOne(ProductsOptions::className(), ['id' => 'product_options_id']);
    }
}
