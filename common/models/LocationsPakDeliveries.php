<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\queries\LocationsPakDeliveriesQuery;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use webdoka\yiiecommerce\common\models\Location;

use Yii;

/**
 * This is the model class for table "locations_pak_deliveries".
 *
 * @property integer $id
 * @property integer $pak_id
 * @property integer $locations_id
 *
 * @property DeliveriesLocationsPak $deliveriesLocationsPak
 * @property DeliveriesLocationsPak $pak
 * @property Locations $locations
 */
class LocationsPakDeliveries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locations_pak_deliveries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pak_id', 'locations_id'], 'required'],
            [['pak_id', 'locations_id'], 'integer'],
            [['pak_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveriesLocationsPak::className(), 'targetAttribute' => ['pak_id' => 'id']],
            [['locations_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['locations_id' => 'id']],
            [['locations_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pak_id' => Yii::t('app', 'Pak ID'),
            'locations_id' => Yii::t('app', 'Locations ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveriesLocationsPak()
    {
        return $this->hasOne(DeliveriesLocationsPak::className(), ['id' => 'pak_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPak()
    {
        return $this->hasOne(DeliveriesLocationsPak::className(), ['id' => 'pak_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasOne(Location::className(), ['id' => 'locations_id']);
    }

    /**
     * @inheritdoc
     * @return LocationsPakDeliveriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LocationsPakDeliveriesQuery(get_called_class());
    }
}
