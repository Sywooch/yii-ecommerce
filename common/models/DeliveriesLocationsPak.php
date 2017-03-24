<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\queries\DeliveriesLocationsPakQuery;

use Yii;

/**
 * This is the model class for table "deliveries_locations_pak".
 *
 * @property integer $id
 * @property string $name
 *
 * @property LocationsPakDeliveries $id0
 * @property LocationsPakDeliveries[] $locationsPakDeliveries
 */
class DeliveriesLocationsPak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveries_locations_pak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => LocationsPakDeliveries::className(), 'targetAttribute' => ['id' => 'pak_id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(LocationsPakDeliveries::className(), ['pak_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationsPakDeliveries()
    {
        return $this->hasMany(LocationsPakDeliveries::className(), ['pak_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DeliveriesLocationsPakQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeliveriesLocationsPakQuery(get_called_class());
    }
}
