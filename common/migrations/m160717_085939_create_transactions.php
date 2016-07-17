<?php

use yii\db\Migration;

/**
 * Handles the creation for table `transactions`.
 */
class m160717_085939_create_transactions extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('transactions', [
            'id' => $this->primaryKey(),
            'type' => 'ENUM("charge", "withdraw", "rollback") NOT NULL',
            'amount' => $this->float()->notNull(),
            'description' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'account_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-transactions-account_id-accounts-id', 'transactions', 'account_id', 'accounts', 'id');

        $this->createTable('orders_transactions', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'transaction_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-orders_transactions-order_id-orders-id', 'orders_transactions', 'order_id', 'orders', 'id');
        $this->addForeignKey('fk-orders_transactions-transaction_id-transactions-id', 'orders_transactions', 'transaction_id', 'transactions', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('orders_transactions');
        $this->dropTable('transactions');
    }
}
