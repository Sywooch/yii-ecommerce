<?php

use yii\db\Migration;

class m160811_081947_create_sets extends Migration {

    public function up() {
        $this->alterColumn('discounts', 'dimension', 'ENUM("percent", "fixed", "set") NOT NULL');

        $this->createTable('sets', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createTable('sets_discounts', [
            'id' => $this->primaryKey(),
            'set_id' => $this->integer()->notNull(),
            'discount_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-sets_discounts-set_id-sets-id', 'sets_discounts', 'set_id', 'sets', 'id');
        $this->addForeignKey('fk-sets_discounts-discount_id-discounts-id', 'sets_discounts', 'discount_id', 'discounts', 'id');

        $this->createTable('sets_products', [
            'id' => $this->primaryKey(),
            'set_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->defaultValue(1),
        ]);

        $this->addForeignKey('fk-sets_products-set_id-sets-id', 'sets_products', 'set_id', 'sets', 'id');
        $this->addForeignKey('fk-sets_products-product_id-products-id', 'sets_products', 'product_id', 'products', 'id');

        $this->createTable('order_sets', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'set_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-order_sets-order_id-orders-id', 'order_sets', 'order_id', 'orders', 'id');
        $this->addForeignKey('fk-order_sets-set_id-sets-id', 'order_sets', 'set_id', 'sets', 'id');

        $this->addColumn('order_items', 'order_set_id', 'INTEGER DEFAULT NULL');
        $this->addForeignKey('fk-order_items-order_set_id-order_sets-id', 'order_items', 'order_set_id', 'order_sets', 'id', 'SET NULL');

        $this->createTable('carts_sets', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'set_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-carts_sets-cart_id-carts-id', 'carts_sets', 'cart_id', 'carts', 'id');
        $this->addForeignKey('fk-carts_sets-set_id-sets-id', 'carts_sets', 'set_id', 'sets', 'id');

        $this->addColumn('carts_products', 'cart_set_id', 'INTEGER DEFAULT NULL');
        $this->addForeignKey('fk-carts_products-cart_set_id-carts_sets-id', 'carts_products', 'cart_set_id', 'carts_sets', 'id', 'SET NULL');
    }

    public function down() {
        $this->dropForeignKey('fk-carts_products-cart_set_id-carts_sets-id', 'carts_products');
        $this->dropColumn('carts_products', 'cart_set_id');

        $this->dropForeignKey('fk-carts_sets-cart_id-carts-id', 'carts_sets');
        $this->dropForeignKey('fk-carts_sets-set_id-sets-id', 'carts_sets');

        $this->dropTable('carts_sets');

        $this->dropForeignKey('fk-order_items-order_set_id-order_sets-id', 'order_items');
        $this->dropColumn('order_items', 'order_set_id');

        $this->dropForeignKey('fk-order_sets-order_id-orders-id', 'order_sets');
        $this->dropForeignKey('fk-order_sets-set_id-sets-id', 'order_sets');

        $this->dropTable('order_sets');

        $this->dropForeignKey('fk-sets_products-set_id-sets-id', 'sets_products');
        $this->dropForeignKey('fk-sets_products-product_id-products-id', 'sets_products');

        $this->dropTable('sets_products');

        $this->dropForeignKey('fk-sets_discounts-set_id-sets-id', 'sets_discounts');
        $this->dropForeignKey('fk-sets_discounts-discount_id-discounts-id', 'sets_discounts');

        $this->dropTable('sets_discounts');

        $this->dropTable('sets');

        $this->alterColumn('discounts', 'dimension', 'ENUM("percent", "fixed") NOT NULL');
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
