<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\CountryQuery;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $name
 * @property string $abbr
 * @property integer $exists_tax
 * @property double $tax
 */
class Country extends \yii\db\ActiveRecord
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
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'abbr'], 'required'],
            [['exists_tax'], 'integer'],
            [['tax'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['abbr'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'abbr' => Yii::t('app', 'Abbreviation'),
            'exists_tax' => Yii::t('app', 'Exists Tax'),
            'tax' => Yii::t('app', 'Tax'),
        ];
    }

    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}
