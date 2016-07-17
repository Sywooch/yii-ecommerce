<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\TransactionQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "transactions".
 *
 * @property integer $id
 * @property double $amount
 * @property integer $account_id
 * @property string $type
 * @property string $description
 * @property string $created_at
 *
 * @property Account $account
 */
class Transaction extends \yii\db\ActiveRecord
{
    const CHARGE_TYPE = 'charge';
    const WITHDRAW_TYPE = 'withdraw';
    const ROLLBACK_TYPE = 'rollback';

    const LIST_TRANSACTION = 'shopListTransaction';
    const VIEW_TRANSACTION = 'shopViewTransaction';
    const CREATE_TRANSACTION = 'shopCreateTransaction';
    const UPDATE_TRANSACTION = 'shopUpdateTransaction';
    const DELETE_TRANSACTION = 'shopDeleteTransaction';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'class' => TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'type'], 'required'],
            ['amount', 'required', 'when' => function ($model) {
                 return $model->type != self::ROLLBACK_TYPE;
            }],
            [['amount'], 'number'],
            [['account_id'], 'integer'],
            [['type'], 'string'],
            [['description'], 'string', 'max' => 255],
            [['created_at'], 'safe'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'account_id' => 'Account ID',
            'type' => 'Type',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id'])->via('ordersTransactions');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersTransactions()
    {
        return $this->hasMany(OrderTransaction::className(), ['transaction_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::CHARGE_TYPE => ucfirst(self::CHARGE_TYPE),
            self::WITHDRAW_TYPE => ucfirst(self::WITHDRAW_TYPE),
            self::ROLLBACK_TYPE => ucfirst(self::ROLLBACK_TYPE),
        ];
    }
}
