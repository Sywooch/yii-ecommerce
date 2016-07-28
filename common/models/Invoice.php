<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\InvoiceQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "invoices".
 *
 * @property integer $id
 * @property double $amount
 * @property string $description
 * @property integer $account_id
 * @property integer $order_id
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order $order
 * @property Account $account
 */
class Invoice extends \yii\db\ActiveRecord
{
    const PENDING_STATUS = 'pending';
    const SUCCESS_STATUS = 'success';
    const FAIL_STATUS = 'fail';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['description', 'status'], 'string'],
            [['account_id'], 'required'],
            [['account_id', 'order_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount' => Yii::t('app', 'Amount'),
            'description' => Yii::t('app', 'Description'),
            'account_id' => Yii::t('app', 'Account ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::PENDING_STATUS => ucfirst(self::PENDING_STATUS),
            self::SUCCESS_STATUS => ucfirst(self::SUCCESS_STATUS),
            self::FAIL_STATUS => ucfirst(self::FAIL_STATUS),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @inheritdoc
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }
}
