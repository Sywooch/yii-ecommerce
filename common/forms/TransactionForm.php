<?php

namespace webdoka\yiiecommerce\common\forms;

use app\models\Profile;
use app\models\User;
use webdoka\yiiecommerce\common\models\Order;
use Yii;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Account;
use webdoka\yiiecommerce\common\models\Transaction;

/**
 * Class TransactionForm
 * @package webdoka\yiiecommerce\common\forms
 */
class TransactionForm extends Transaction
{
    public $profile, $order, $transaction;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['profile'], 'required'],
            [['order'],
                'exist',
                'skipOnEmpty' => false,
                'skipOnError' => false,
                'targetClass' => Order::className(),
                'targetAttribute' => ['order' => 'id'],
                'when' => function ($model) {
                    return $model->type == self::WITHDRAW_TYPE;
                }
            ],
            [['transaction'],
                'exist',
                'skipOnEmpty' => false,
                'skipOnError' => false,
                'targetClass' => Transaction::className(),
                'targetAttribute' => ['transaction' => 'id'],
                'when' => function ($model) {
                    return $model->type == self::ROLLBACK_TYPE;
                }
            ],

        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'profile' => Yii::t('shop','Profile'),
            'order' => Yii::t('shop','Order'),
            'transaction' => Yii::t('shop','Transaction'),
            'amount' => Yii::t('shop', 'Amount'),
            'account_id' => Yii::t('shop', 'Account ID'),
            'type' => Yii::t('shop', 'Type'),
            'description' => Yii::t('shop', 'Description'),
            'created_at' => Yii::t('shop', 'Created At'),
            'transaction_id' => Yii::t('shop', 'Transaction'),
        ];
    }

    /**
     * Returns all users
     * @return array
     */
    public static function getUsers()
    {
        return User::find()
            ->with('profile')
            ->orderBy('username')
            ->all();
    }

    /**
     * Returns all accounts by profile
     * @param $profile
     * @return array
     */
    public static function getAccountsByProfile($profile)
    {
        return Account::find()
            ->select('name')
            ->indexBy('id')
            ->where(['profile_id' => $profile])
            ->orderBy(['name' => 'asc'])
            ->column();
    }

    /**
     * Returns all orders by profile
     * @param $profile
     * @return array
     */
    public static function getOrdersByProfile($profile)
    {
        return Order::find()
            ->select('id')
            ->indexBy('id')
            ->where(['profile_id' => $profile])
            ->orderBy(['id' => 'asc'])
            ->column();
    }

    /**
     * Returns all transactions by account
     * @param $account
     * @return array
     */
    public static function getTransactionsByAccount($account)
    {
        return Transaction::find()
            ->andWhere('account_id = :account_id')
            ->andWhere('type <> :type')
            ->params([':account_id' => $account, ':type' => self::ROLLBACK_TYPE])
            ->select('id')
            ->indexBy('id')
            ->orderBy(['id' => 'asc'])
            ->column();
    }
}
