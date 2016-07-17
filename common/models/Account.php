<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property integer $name
 * @property double $balance
 * @property integer $currency_id
 * @property integer $user_id
 *
 * @property User $user
 * @property Currency $currency
 */
class Account extends \yii\db\ActiveRecord
{
    const LIST_ACCOUNT = 'shopListAccount';
    const VIEW_ACCOUNT = 'shopViewAccount';
    const CREATE_ACCOUNT = 'shopCreateAccount';
    const UPDATE_ACCOUNT = 'shopUpdateAccount';
    const DELETE_ACCOUNT = 'shopDeleteAccount';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id', 'user_id', 'name'], 'required'],
            [['balance'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['currency_id', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
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
            'balance' => 'Balance',
            'currency_id' => 'Currency ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
}
