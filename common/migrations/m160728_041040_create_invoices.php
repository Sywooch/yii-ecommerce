<?php

use yii\db\Migration;

class m160728_041040_create_invoices extends Migration {

    public function up() {
        $this->createTable('invoices', [
            'id' => $this->primaryKey(),
            'amount' => $this->float(),
            'description' => $this->text(),
            'account_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->defaultValue(null),
            'status' => 'ENUM("pending", "success", "fail") DEFAULT "pending"',
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk-invoices-account_id-accounts-id', 'invoices', 'account_id', 'accounts', 'id');
        $this->addForeignKey('fk-orders-order_id-orders-id', 'invoices', 'order_id', 'orders', 'id');
    }

    public function down() {
        $this->dropTable('invoices');
    }

}
