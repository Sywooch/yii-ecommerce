<?php

use yii\db\Migration;

class m160719_023201_create_prices extends Migration
{
    public function safeUp()
    {
        $this->createTable('prices', [
            'id' => $this->primaryKey(),
            'label' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'auth_item_name' => $this->string(64)->notNull(),
        ]);

//        $this->addForeignKey('fk-prices-auth_item_name-auth_item-name', 'prices', 'auth_item_name', 'auth_item', 'name');

        $this->createTable('products_prices', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'price_id' => $this->integer()->notNull(),
            'value' => $this->float()
        ]);

        $this->addForeignKey('fk-products_prices-product_id-products-id', 'products_prices', 'product_id', 'products', 'id', 'CASCADE');
        $this->addForeignKey('fk-products_prices-price_id-products-id', 'products_prices', 'price_id', 'prices', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-products_prices-product_id-products-id', 'products_prices');
        $this->dropForeignKey('fk-products_prices-price_id-products-id', 'products_prices');

        $this->dropTable('products_prices');

        $this->dropForeignKey('fk-prices-auth_item_name-auth_item_name', 'prices');
        $this->dropTable('prices');
    }
}
