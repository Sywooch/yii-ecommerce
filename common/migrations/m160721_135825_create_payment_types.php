<?php

use yii\db\Migration;

/**
 * Handles the creation for table `payment_types`.
 */
class m160721_135825_create_payment_types extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment_types', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addColumn('orders', 'payment_type_id', 'INTEGER');
        $this->addForeignKey('fk-orders-payment_type_id-payment_types-id', 'orders', 'payment_type_id', 'payment_types', 'id', 'SET NULL', 'SET NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-orders-payment_type_id-payment_types-id', 'orders');
        $this->dropColumn('orders', 'payment_type_id');

        $this->dropTable('payment_types');
    }
}
