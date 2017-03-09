<?php

use yii\db\Migration;

/**
 * Handles the creation for table `order_properties`.
 */
class m160716_121236_create_properties extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('properties', [
            'id' => $this->primaryKey(),
            'label' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => 'ENUM("input", "checkbox", "textarea") DEFAULT "input"',
            'required' => $this->boolean()->defaultValue(false),
        ]);

        $this->createTable('orders_properties', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'property_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ]);

        $this->addForeignKey('fk-orders_properties-order_id-orders-id', 'orders_properties', 'order_id', 'orders', 'id');
        $this->addForeignKey('fk-orders_properties-property_id-properties-id', 'orders_properties', 'property_id', 'properties', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropForeignKey('fk-orders_properties-order_id-orders-id', 'orders_properties');
        $this->dropForeignKey('fk-orders_properties-property_id-properties-id', 'orders_properties');

        $this->dropTable('orders_properties');
        $this->dropTable('properties');
    }

}
