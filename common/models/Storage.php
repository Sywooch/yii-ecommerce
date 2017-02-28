<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\queries\StorageQuery;
use Yii;

/**
 * This is the model class for table "storages".
 *
 * @property integer $id
 * @property string $uid
 * @property string $name
 * @property integer $location_id
 * @property string $schedule
 * @property string $phones
 * @property string $email
 * @property string $icon
 *
 * @property Delivery[] $deliveries
 * @property Location $location
 */
class Storage extends UidModel
{
    const LIST_STORAGE = 'shopListStorage';
    const VIEW_STORAGE = 'shopViewStorage';
    const CREATE_STORAGE = 'shopCreateStorage';
    const UPDATE_STORAGE = 'shopUpdateStorage';
    const DELETE_STORAGE = 'shopDeleteStorage';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'location_id', 'schedule'], 'required'],
            [['location_id'], 'integer'],
            [['schedule'], 'string'],
            [['uid', 'name', 'phones', 'email', 'icon'], 'string', 'max' => 255],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'uid' => Yii::t('shop', 'Uid'),
            'name' => Yii::t('shop', 'Name'),
            'location_id' => Yii::t('shop', 'Location ID'),
            'schedule' => Yii::t('shop', 'Schedule'),
            'phones' => Yii::t('shop', 'Phones'),
            'email' => Yii::t('shop', 'Email'),
            'icon' => Yii::t('shop', 'Icon'),
            'address' => Yii::t('shop', 'Address')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveries()
    {
        return $this->hasMany(Delivery::className(), ['storage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @inheritdoc
     * @return StorageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StorageQuery(get_called_class());
    }

    public function getIconUrl()
    {
        return Yii::getAlias('@web') . '/uploads/' . $this->icon;
    }
}
