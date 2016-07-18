<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Order;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\User;
use webdoka\yiiecommerce\common\models\Account;
use webdoka\yiiecommerce\common\models\Transaction;

/**
 * Class TransactionForm
 * @package webdoka\yiiecommerce\common\forms
 */
class TransactionForm extends Transaction
{
    public $user, $order, $transaction;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['user'], 'required'],
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
            'user' => 'User',
            'order' => 'Order',
            'transaction' => 'Transaction',
        ];
    }

    /**
     * Returns all users
     * @return array
     */
    public static function getUsers()
    {
        return User::find()
            ->select('username')
            ->indexBy('id')
            ->orderBy(['username' => 'asc'])
            ->column();
    }

    /**
     * Returns all accounts by user
     * @param $user
     * @return array
     */
    public static function getAccountsByUser($user)
    {
        return Account::find()
            ->where(['user_id' => $user])
            ->select('name')
            ->indexBy('id')
            ->orderBy(['name' => 'asc'])
            ->column();
    }

    /**
     * Returns all orders by user
     * @param $user
     * @return array
     */
    public static function getOrdersByUser($user)
    {
        return Order::find()
            ->where(['user_id' => $user])
            ->select('id')
            ->indexBy('id')
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
