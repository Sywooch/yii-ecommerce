<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\SetDiscountQuery;

/**
 * This is the model class for table "sets_discounts".
 *
 * @property integer $id
 * @property integer $set_id
 * @property integer $discount_id
 *
 * @property Discount $discount
 * @property Set $set
 */
class SetDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sets_discounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['set_id', 'discount_id'], 'required'],
            [['set_id', 'discount_id'], 'integer'],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'id']],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => Set::className(), 'targetAttribute' => ['set_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'set_id' => Yii::t('app', 'Set ID'),
            'discount_id' => Yii::t('app', 'Discount ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['id' => 'discount_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSet()
    {
        return $this->hasOne(Set::className(), ['id' => 'set_id']);
    }

    /**
     * @inheritdoc
     * @return SetDiscountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SetDiscountQuery(get_called_class());
    }
}
