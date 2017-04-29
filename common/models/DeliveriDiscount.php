<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "deliveries_discounts".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $discount_value
 * @property string $value_type
 *
 * @property DeliveriesHasDiscounts[] $deliveriesHasDiscounts
 */
class DeliveriDiscount extends \yii\db\ActiveRecord
{
    
    const TYPE_OVERPRICE = 0;
    const TYPE_OVERQUANTITY = 1;
    const TYPE_ABOVEWEIGHT = 2;

    const TYPE_VALUE_PERCENT = 'percent';
    const TYPE_VALUE_UNIT = 'unit';
   
    public static function getTypeLists()
    {
        return [
        self::TYPE_OVERPRICE => Yii::t('shop', 'Over price'),
        self::TYPE_OVERQUANTITY => Yii::t('shop', 'Over quantity'),
        self::TYPE_ABOVEWEIGHT => Yii::t('shop', 'Above weight'),
        ];
    }

    public static function getValueTypeLists()
    {
        return [
        self::TYPE_VALUE_PERCENT => Yii::t('shop', 'Percent'),
        self::TYPE_VALUE_UNIT => Yii::t('shop', 'Unit'),
        ];
    }    


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveries_discounts';
    }


    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type', 'discount_value', 'delivery_value'], 'integer'],
            [['discount_value_type'], 'string'],
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
            'type' => Yii::t('shop', 'Type'),
            'discount_value' => Yii::t('shop', 'Discount Value'),
            'delivery_value' => Yii::t('shop', 'Delivery Value'),
            'discount_value_type' => Yii::t('shop', 'Discount Value Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveriesHasDiscounts()
    {
        return $this->hasMany(\webdoka\yiiecommerce\common\models\DeliveriesHasDiscounts::className(), ['discount_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DeliverieDiscountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \webdoka\yiiecommerce\common\queries\DeliverieDiscountQuery(get_called_class());
    }
}
