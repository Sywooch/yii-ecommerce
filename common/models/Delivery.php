<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\queries\DeliveryQuery;
use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property integer $id
 * @property string $uid
 * @property string $name
 * @property double $cost
 * @property integer $storage_id
 *
 * @property Location $location
 */
class Delivery extends UidModel
{
    const LIST_DELIVERY = 'shopListDelivery';
    const VIEW_DELIVERY = 'shopViewDelivery';
    const CREATE_DELIVERY = 'shopCreateDelivery';
    const UPDATE_DELIVERY = 'shopUpdateDelivery';
    const DELETE_DELIVERY = 'shopDeleteDelivery';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cost', 'storage_id'], 'required'],
            [['cost'], 'number'],
            [['storage_id'], 'integer'],
            [['uid', 'name'], 'string', 'max' => 255],
            [['storage_id'], 'exist', 'skipOnError' => false, 'targetClass' => Storage::className(), 'targetAttribute' => ['storage_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
            'cost' => 'Cost',
            'storage_id' => 'Storage ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorage()
    {
        return $this->hasOne(Storage::className(), ['id' => 'storage_id']);
    }

    /**
     * @inheritdoc
     * @return DeliveryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeliveryQuery(get_called_class());
    }
}