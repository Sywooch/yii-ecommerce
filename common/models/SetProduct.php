<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\SetProductQuery;

/**
 * This is the model class for table "sets_products".
 *
 * @property integer $id
 * @property integer $set_id
 * @property integer $product_id
 * @property integer $quantity
 *
 * @property Product $product
 * @property Set $set
 */
class SetProduct extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'sets_products';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['set_id', 'product_id'], 'required'],
            [['set_id', 'product_id', 'quantity'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => Set::className(), 'targetAttribute' => ['set_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('shop', 'ID'),
            'set_id' => Yii::t('shop', 'Set ID'),
            'product_id' => Yii::t('shop', 'Product ID'),
            'quantity' => Yii::t('shop', 'Quantity'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSet() {
        return $this->hasOne(Set::className(), ['id' => 'set_id']);
    }

    /**
     * @inheritdoc
     * @return SetProductQuery the active query used by this AR class.
     */
    public static function find() {
        return new SetProductQuery(get_called_class());
    }

}
