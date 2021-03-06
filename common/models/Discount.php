<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\DiscountQuery;

/**
 * This is the model class for table "discounts".
 *
 * @property integer $id
 * @property string $name
 * @property string $dimension
 * @property double $value
 * @property string $started_at
 * @property string $finished_at
 * @property integer $count
 *
 * @property ProductDiscount[] $productsDiscounts
 */
class Discount extends \yii\db\ActiveRecord
{

    const PERCENT_DIMENSION = 'percent';
    const FIXED_DIMENSION = 'fixed';
    const SET_DIMENSION = 'set';
    const LIST_DISCOUNT = 'shopListDiscount';
    const VIEW_DISCOUNT = 'shopViewDiscount';
    const CREATE_DISCOUNT = 'shopCreateDiscount';
    const UPDATE_DISCOUNT = 'shopUpdateDiscount';
    const DELETE_DISCOUNT = 'shopDeleteDiscount';

    /**
     * @return array
     */
    public static function getDimensions()
    {
        return [
            self::PERCENT_DIMENSION => Yii::t('shop', 'Percent'),
            self::FIXED_DIMENSION => Yii::t('shop', 'Fixed'),
            self::SET_DIMENSION => Yii::t('shop', 'Set'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['dimension'], 'string'],
            [['value'], 'number'],
            [['count'], 'integer'],
            [['started_at', 'finished_at'], 'default', 'value' => null],
            //[['started_at', 'finished_at'],  'date',     'format' => 'yyyy-mm-dd'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'name' => Yii::t('shop', 'Name'),
            'dimension' => Yii::t('shop', 'Dimension'),
            'value' => Yii::t('shop', 'Value'),
            'started_at' => Yii::t('shop', 'Started At'),
            'finished_at' => Yii::t('shop', 'Finished At'),
            'count' => Yii::t('shop', 'Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsDiscounts()
    {
        return $this->hasMany(ProductDiscount::className(), ['discount_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->via('productsDiscounts');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getProductsGroupedByCategory()
    {
        return Product::find()
            ->innerJoinWith('category')
            ->all();
    }

    /**
     * @inheritdoc
     * @return DiscountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscountQuery(get_called_class());
    }

    /**
     * After save get related records, and unlink/link them if it needs.
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $relatedRecords = $this->getRelatedRecords();

        if ($this->isRelationPopulated('products')) {
            $this->unlinkAll('products', true);
            foreach ($relatedRecords['products'] as $relatedRecord) {
                $this->link('products', $relatedRecord);
            }
        }
    }

}
