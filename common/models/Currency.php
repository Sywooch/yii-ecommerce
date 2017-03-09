<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property integer $id
 * @property string $name
 * @property string $symbol
 * @property string $abbr
 *
 * @property Account[] $accounts
 */
class Currency extends \yii\db\ActiveRecord {

    const LIST_CURRENCY = 'shopListCurrency';
    const VIEW_CURRENCY = 'shopViewCurrency';
    const CREATE_CURRENCY = 'shopCreateCurrency';
    const UPDATE_CURRENCY = 'shopUpdateCurrency';
    const DELETE_CURRENCY = 'shopDeleteCurrency';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'symbol', 'abbr'], 'required'],
            [['name', 'symbol', 'abbr'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('shop', 'ID'),
            'name' => Yii::t('shop', 'Name'),
            'symbol' => Yii::t('shop', 'Symbol'),
            'abbr' => Yii::t('shop', 'Abbr'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount() {
        return $this->hasMany(Account::className(), ['currency_id' => 'id']);
    }

}
