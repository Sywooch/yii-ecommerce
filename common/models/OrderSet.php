<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\OrderSetQuery;

/**
 * This is the model class for table "order_sets".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $set_id
 *
 * @property OrderItem[] $orderItems
 * @property Set $set
 * @property Order $order
 */
class OrderSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_sets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'set_id'], 'required'],
            [['order_id', 'set_id'], 'integer'],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => Set::className(), 'targetAttribute' => ['set_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'set_id' => Yii::t('app', 'Set ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_set_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSet()
    {
        return $this->hasOne(Set::className(), ['id' => 'set_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @inheritdoc
     * @return OrderSetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderSetQuery(get_called_class());
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $relatedRecords = $this->getRelatedRecords();

        if ($this->isRelationPopulated('orderItems')) {
            if ($this->isNewRecord) {
                $this->unlinkAll('orderItems');
            }
            foreach ($relatedRecords['orderItems'] as $relatedRecord) {
                $relatedRecord->order_id = $this->order_id;
                $this->link('orderItems', $relatedRecord);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
