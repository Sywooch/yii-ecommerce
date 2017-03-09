<?php

use yii\db\Migration;

class m160602_144846_common_tables extends Migration {

    public function safeUp() {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()
        ]);

        $this->addForeignKey('fk_categories_parent_id', 'categories', 'parent_id', 'categories', 'id', 'SET NULL');

        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'price' => $this->float()->notNull(),
            'features' => $this->text()
        ]);

        $this->addForeignKey('fk_products_category_id', 'products', 'category_id', 'categories', 'id', 'SET NULL');

        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'address' => $this->string(),
            'notes' => $this->text(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createTable('order_items', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'quantity' => $this->integer(),
        ]);

        $this->addForeignKey('fk_order_items_order_id', 'order_items', 'order_id', 'orders', 'id', 'CASCADE');
        $this->addForeignKey('fk_order_items_product_id', 'order_items', 'product_id', 'products', 'id', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('fk_order_items_product_id', 'order_items');
        $this->dropForeignKey('fk_order_items_order_id', 'order_items');

        $this->dropTable('order_items');

        $this->dropTable('orders');

        $this->dropForeignKey('fk_products_category_id', 'products');

        $this->dropTable('products');

        $this->dropForeignKey('fk_categories_parent_id', 'categories');

        $this->dropTable('categories');
    }

}
