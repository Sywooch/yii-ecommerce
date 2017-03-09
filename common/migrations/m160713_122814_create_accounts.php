<?php

use yii\db\Migration;

/**
 * Handles the creation for table `accounts`.
 */
class m160713_122814_create_accounts extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('accounts', [
            'id' => $this->primaryKey(),
            'balance' => $this->float(),
            'currency_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-accounts-currency_id-currencies-id', 'accounts', 'currency_id', 'currencies', 'id');
        $this->addForeignKey('fk-accounts-user_id-users-id', 'accounts', 'user_id', 'users', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropForeignKey('fk-accounts-currency_id-currencies-id', 'accounts');
        $this->dropForeignKey('fk-accounts-user_id-users-id', 'accounts');

        $this->dropTable('accounts');
    }

}
