<?php

use yii\db\Migration;

/**
 * Handles the creation for table `cart_table`.
 */
class m160610_082029_create_cart_table extends Migration {

    public function safeUp() {
        $this->createTable('carts', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('carts_products', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()
        ]);

        $this->addForeignKey('fk-carts_products-cart_id-cart-id', 'carts_products', 'cart_id', 'carts', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-carts_products-product_id-products-id', 'carts_products', 'product_id', 'products', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropTable('carts_products');
        $this->dropTable('carts');
    }

}
