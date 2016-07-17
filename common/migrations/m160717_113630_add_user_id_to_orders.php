<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `orders`.
 */
class m160717_113630_add_user_id_to_orders extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
//        $this->dropColumn('orders', 'phone');
//        $this->dropColumn('orders', 'email');
//        $this->dropColumn('orders', 'address');
//        $this->dropColumn('orders', 'notes');

//        $this->addColumn('orders', 'user_id', 'INTEGER NOT NULL');
        $this->addForeignKey('fk-orders-user_id-users-id', 'orders', 'user_id', 'users', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('orders', 'phone', 'VARCHAR(255) NOT NULL');
        $this->addColumn('orders', 'email', 'VARCHAR(255) NOT NULL');
        $this->addColumn('orders', 'address', 'VARCHAR(255) NOT NULL');
        $this->addColumn('orders', 'notes', 'TEXT');

        $this->dropForeignKey('fk-orders-user_id-users-id', 'orders');
        $this->dropColumn('orders', 'user_id');
    }
}
