<?php

use yii\db\Migration;

/**
 * Handles the creation for table `order_history`.
 */
class m160721_145333_create_order_history extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_history', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-order_history-order_id-orders-id', 'order_history', 'order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-order_history-order_id-orders-id', 'order_history');
        $this->dropTable('order_history');
    }

}
