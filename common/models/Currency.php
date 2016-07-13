<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property integer $id
 * @property string $name
 * @property string $symbol
 *
 * @property Account[] $accounts
 */
class Currency extends \yii\db\ActiveRecord
{
    const LIST_CURRENCY = 'shopListCurrency';
    const VIEW_CURRENCY = 'shopViewCurrency';
    const CREATE_CURRENCY = 'shopCreateCurrency';
    const UPDATE_CURRENCY = 'shopUpdateCurrency';
    const DELETE_CURRENCY = 'shopDeleteCurrency';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'symbol'], 'required'],
            [['name', 'symbol'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'symbol' => 'Symbol',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasMany(Account::className(), ['currency_id' => 'id']);
    }
}
