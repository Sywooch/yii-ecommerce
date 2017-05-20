<?php

use yii\db\Migration;

class m170515_170230_create_products_variants_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%products_variants}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'fields' => $this->text(),
            'quantity_stock' => $this->integer(),
            'vendor_code' => $this->integer(),
            'price' => $this->money(10, 2),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp(),
        ]);

        $this->addForeignKey(
            'fk-products_variants-product_id-products-id',
            'products_variants',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%products_variants_value}}', [
            'id' => $this->primaryKey(),
            'products_variants_id' => $this->integer()->notNull(),
            'products_options_id' => $this->integer()->notNull(),
            'products_value_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-products_variants_value-variants_id-variants-id',
            'products_variants_value',
            'products_variants_id',
            'products_variants',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-products_variants_value-variants_id-options-id',
            'products_variants_value',
            'products_options_id',
            'products_options',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-products_variants_value-value_id-options-id',
            'products_variants_value',
            'products_value_id',
            'products_options',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-products_variants_value-value_id-options-id',
            '{{%products_variants_value}}'
        );
        $this->dropForeignKey(
            'fk-products_variants-product_id-products-id',
            '{{%products_variants}}'
        );
        $this->dropForeignKey(
            'fk-products_variants_value-variants_id-variants-id',
            '{{%products_variants_value}}'
        );
        $this->dropForeignKey(
            'fk-products_variants_value-variants_id-options-id',
            '{{%products_variants_value}}'
        );
        $this->dropTable('{{%products_variants}}');
        $this->dropTable('{{%products_variants_value}}');
    }
}
