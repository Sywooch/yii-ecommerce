<?php

namespace webdoka\yiiecommerce\common\components;

use webdoka\yiiecommerce\common\models\Order;
use webdoka\yiiecommerce\common\models\OrderTransaction;
use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidParamException;
use webdoka\yiiecommerce\common\models\Account;
use webdoka\yiiecommerce\common\models\Transaction;

class Billing extends Component
{
    /**
     * Creates charge for account
     * @param $accountId
     * @param $amount
     * @param string $description
     * @return bool
     * @throws \yii\db\Exception
     */
    public function charge($accountId, $amount, $description)
    {
        if (!$account = Account::find()->where(['id' => $accountId])->one()) {
            throw new InvalidParamException('Invalid $accountId.');
        }

        $transaction = new Transaction();
        $transaction->type = Transaction::CHARGE_TYPE;
        $transaction->amount = $amount;
        $transaction->description = $description ?: 'Charge';
        $transaction->account_id = $accountId;

        $dbTransaction = Yii::$app->db->beginTransaction();

        if ($transaction->save()) {
            $account->balance += abs($amount);
            if ($account->save()) {
                $dbTransaction->commit();
                return true;
            }
        }

        $dbTransaction->rollBack();
        return false;
    }

    /**
     * Creates withdraw for account
     * @param $accountId
     * @param $amount
     * @param string $description
     * @param bool|false $orderId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function withdraw($accountId, $amount, $description, $orderId = false)
    {
        if (!$account = Account::find()->where(['id' => $accountId])->one()) {
            throw new InvalidParamException('Invalid $accountId.');
        }

        if (!($order = Order::find()->where(['id' => $orderId])->one()) && $orderId) {
            throw new InvalidParamException('Invalid $orderId.');
        }

        $transaction = new Transaction();
        $transaction->type = Transaction::WITHDRAW_TYPE;
        $transaction->amount = $amount;
        $transaction->description = $description ?: 'Withdraw';
        $transaction->account_id = $accountId;

        $dbTransaction = Yii::$app->db->beginTransaction();

        $result = true;

        if ($result &= $transaction->save()) {
            if ($order) {
                $orderTransaction = new OrderTransaction();
                $orderTransaction->order_id = $order->id;
                $orderTransaction->transaction_id = $transaction->id;
                $result &= $orderTransaction->save();
            }

            if ($result) {
                $account->balance -= abs($amount);
                $result &= $account->save();
            }
        }

        if ($result) {
            $dbTransaction->commit();
            return true;
        }

        $dbTransaction->rollBack();
        return false;
    }

    /**
     * Rollbacks charge or withdraw transaction
     * @param $transactionId
     * @param string $description
     * @return bool
     * @throws \yii\db\Exception
     */
    public function rollback($transactionId, $description)
    {
        if (!$transaction = Transaction::find()->where(['id' => $transactionId])->one()) {
            throw new InvalidParamException('Invalid $transactionId.');
        }

        if ($transaction->type == Transaction::ROLLBACK_TYPE) {
            throw new InvalidParamException('Impossible rollback transaction which has rollback type.');
        }

        if (!$account = $transaction->account) {
            throw new InvalidParamException('Account not found.');
        }

        $rollbackTransaction = new Transaction();
        $rollbackTransaction->type = Transaction::ROLLBACK_TYPE;
        $rollbackTransaction->amount = $transaction->amount;
        $rollbackTransaction->description = $description ?: 'Rollback';
        $rollbackTransaction->account_id = $transaction->account_id;
        $rollbackTransaction->transaction_id = $transaction->id;

        $dbTransaction = Yii::$app->db->beginTransaction();

        $result = true;

        if ($result &= $rollbackTransaction->save()) {

            if ($transaction->order) {
                $orderTransaction = new OrderTransaction();
                $orderTransaction->transaction_id = $rollbackTransaction->id;
                $orderTransaction->order_id = $transaction->order->id;
                $result &= $orderTransaction->save();
            }

            if ($transaction->type == Transaction::CHARGE_TYPE) {
                $account->balance -= abs($rollbackTransaction->amount);
            } else {
                $account->balance += abs($rollbackTransaction->amount);
            }
            $result &= $account->save();
        }

        if ($result) {
            $dbTransaction->commit();
            return true;
        }

        $dbTransaction->rollBack();
        return false;
    }
}