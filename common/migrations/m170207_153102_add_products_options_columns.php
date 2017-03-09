<?php

use yii\db\Migration;

class m170207_153102_add_products_options_columns extends Migration {

    public function safeUp() {
        $this->addColumn('{{%products_options}}', 'description', $this->text());
        $this->addColumn('{{%products_options}}', 'image', $this->string());
        $this->addColumn('{{%carts_products}}', 'option_id', $this->integer()->Null()->defaultValue(0));
        $this->addColumn('{{%order_items}}', 'option_id', $this->integer()->Null()->defaultValue(0));
        $this->execute("ALTER TABLE {{%products_options}} ADD `status` TINYINT( 1 ) NOT NULL DEFAULT '1';");


        $this->createTable('products_options_prices', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'product_options_id' => $this->integer()->notNull(),
            'price_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(true),
            'value' => $this->float()
        ]);
        $this->addForeignKey('fk-products_options_prices-product_id-products-id', 'products_options_prices', 'product_id', 'products', 'id', 'CASCADE');

        $this->addForeignKey('fk-products_options_prices-product_options_id-product_options-id', 'products_options_prices', 'product_options_id', 'products_options', 'id', 'CASCADE');
        $this->addForeignKey('fk-products_options_prices-price_id-products_options-id', 'products_options_prices', 'price_id', 'prices', 'id', 'CASCADE');
    }

    public function safeDown() {
        $this->dropColumn('{{%products_options}}', 'description');
        $this->dropColumn('{{%products_options}}', 'image');
        $this->dropColumn('{{%products_options}}', 'status');
        $this->dropColumn('{{%carts_products}}', 'option_id');
        $this->dropColumn('{{%order_items}}', 'option_id');
        $this->dropForeignKey('fk-products_options_prices-product_id-products-id', 'products_options_prices');
        $this->dropForeignKey('fk-products_options_prices-product_options_id-product_options-id', 'products_options_prices');
        $this->dropForeignKey('fk-products_options_prices-price_id-products_options-id', 'products_options_prices');
        $this->dropTable('products_options_prices');
    }

}
