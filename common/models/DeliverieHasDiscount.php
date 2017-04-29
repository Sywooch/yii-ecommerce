<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "deliveries_has_discounts".
 *
 * @property integer $id
 * @property integer $deliveri_id
 * @property integer $discount_id
 *
 * @property Deliveries $deliveri
 * @property DeliveriesDiscounts $discount
 */
class DeliverieHasDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveries_has_discounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deliveri_id', 'discount_id'], 'required'],
            [['deliveri_id', 'discount_id'], 'integer'],
            [['deliveri_id'], 'exist', 'skipOnError' => true, 'targetClass' => Deliveries::className(), 'targetAttribute' => ['deliveri_id' => 'id']],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveriesDiscounts::className(), 'targetAttribute' => ['discount_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'deliveri_id' => Yii::t('shop', 'Deliveri ID'),
            'discount_id' => Yii::t('shop', 'Discount ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveri()
    {
        return $this->hasOne(\webdoka\yiiecommerce\common\models\Deliveries::className(), ['id' => 'deliveri_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(\webdoka\yiiecommerce\common\models\DeliveriesDiscounts::className(), ['id' => 'discount_id']);
    }

    /**
     * @inheritdoc
     * @return DeliverieHasDiscountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \webdoka\yiiecommerce\common\queries\DeliverieHasDiscountQuery(get_called_class());
    }
}
