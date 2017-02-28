<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use app\models\Profile;
use webdoka\yiiecommerce\common\queries\AccountQuery;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property integer $name
 * @property double $balance
 * @property integer $currency_id
 * @property integer $profile_id
 *
 * @property Profile $profile
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
            [['currency_id', 'profile_id', 'name'], 'required'],
            [['balance'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['currency_id', 'profile_id'], 'integer'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop','ID'),
            'name' => Yii::t('shop','Name'),
            'balance' => Yii::t('shop','Balance'),
            'currency_id' => Yii::t('shop','Currency ID'),
            'profile_id' => Yii::t('shop','Profile ID'),
            'default' => Yii::t('shop','Default'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['account_id' => 'id'])->orderBy(['id' => 'desc']);
    }

    /**
     * Delete linked transactions
     * @return bool
     */
    public function beforeDelete()
    {
        $this->unlinkAll('transactions', true);

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * @return AccountQuery
     */
    public static function find()
    {
        return new AccountQuery(get_called_class());
    }
}
