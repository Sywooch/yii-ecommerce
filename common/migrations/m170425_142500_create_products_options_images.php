<?php

use yii\db\Migration;

class m170425_142500_create_products_options_images extends Migration
{
    public function safeUp()
    {
        $this->createTable('products_options_images', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'product_options_id' => $this->integer()->notNull(),
            'image' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk-products_options_images-product_id-products-id',
            'products_options_images',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-products_options_images-product_options_id-product_options-id',
            'products_options_images',
            'product_options_id',
            'products_options',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-products_options_images-product_id-products-id',
            'products_options_images'
        );

        $this->dropForeignKey(
            'fk-products_options_images-product_options_id-product_options-id',
            'products_options_images'
        );

        $this->dropTable('products_options_images');
    }
}
