<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\CitiesQuery;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $city
 * @property string $state
 * @property string $region
 * @property integer $biggest_city
 *
 * @property Countries $country
 */
class Cities extends \yii\db\ActiveRecord
{
    
    const LIST_COUNTRY = 'shopListCountry';
    const VIEW_COUNTRY = 'shopViewCountry';
    const CREATE_COUNTRY = 'shopCreateCountry';
    const UPDATE_COUNTRY = 'shopUpdateCountry';
    const DELETE_COUNTRY = 'shopDeleteCountry';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country_id', 'city', 'region'], 'required'],
            [['id', 'country_id', 'biggest_city'], 'integer'],
            [['city', 'state', 'region'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'region' => Yii::t('app', 'Region'),
            'biggest_city' => Yii::t('app', 'Biggest City'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @inheritdoc
     * @return CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }
}
