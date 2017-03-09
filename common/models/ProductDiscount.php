<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\ProductDiscountQuery;

/**
 * This is the model class for table "products_discounts".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $discount_id
 *
 * @property Discount $discount
 * @property Product $product
 */
class ProductDiscount extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'products_discounts';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['product_id', 'discount_id'], 'required'],
            [['product_id', 'discount_id'], 'integer'],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('shop', 'ID'),
            'product_id' => Yii::t('shop', 'Product ID'),
            'discount_id' => Yii::t('shop', 'Discount ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount() {
        return $this->hasOne(Discount::className(), ['id' => 'discount_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return ProductDiscountQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProductDiscountQuery(get_called_class());
    }

}
