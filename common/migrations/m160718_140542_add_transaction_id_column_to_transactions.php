<?php

use yii\db\Migration;

/**
 * Handles adding transaction_id_column to table `transactions`.
 */
class m160718_140542_add_transaction_id_column_to_transactions extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('transactions', 'transaction_id', 'INTEGER DEFAULT NULL');
        $this->addForeignKey('fk-transactions-transaction_id-transactions-id', 'transactions', 'transaction_id', 'transactions', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-transactions-transaction_id-transactions-id', 'transactions');
        $this->dropColumn('transactions', 'transaction_id');
    }
}
