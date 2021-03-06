<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\queries\LocationQuery;
use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property integer $id
 * @property string $uid
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $index
 */
class Location extends UidModel
{

    const LIST_LOCATION = 'shopListLocation';
    const VIEW_LOCATION = 'shopViewLocation';
    const CREATE_LOCATION = 'shopCreateLocation';
    const UPDATE_LOCATION = 'shopUpdateLocation';
    const DELETE_LOCATION = 'shopDeleteLocation';
    const TYPE_DELIVERY = '1';
    const TYPE_STORAGE = '0';

    public $state;
    public $bigcity;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country'], 'required'],
            [['type'], 'integer'],
            [['uid', 'country', 'region', 'city', 'address', 'index'], 'string', 'max' => 255],
            //[['country'], 'unique'],
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
            'country' => Yii::t('shop', 'Country'),
            'city' => Yii::t('shop', 'City'),
            'address' => Yii::t('shop', 'Address'),
            'full' => Yii::t('shop', 'Full address'),
            'index' => Yii::t('shop', 'Index'),
            'region' => Yii::t('shop', 'Region'),
            'state' => Yii::t('shop', 'State'),
            'type' => Yii::t('shop', 'Type'),
        ];
    }

    /**
     * @inheritdoc
     * @return LocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LocationQuery(get_called_class());
    }

    /**
     * Returns full address
     * @return string
     */
    public function getFull()
    {
        return sprintf('%s, %s, %s', $this->country, $this->city, $this->address);
    }
}
