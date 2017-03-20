<?php

use yii\db\Migration;

/**
 * Handles the creation for table `discounts`.
 */
class m160726_024931_create_discounts extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('discounts', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'dimension' => 'ENUM("percent", "fixed") DEFAULT "percent"',
            'value' => $this->float()->notNull(),
            'started_at' => $this->dateTime()->defaultValue(NULL),
            'finished_at' => $this->dateTime()->defaultValue(NULL),
            'count' => $this->integer()->defaultValue(NULL)
        ]);

        $this->createTable('products_discounts', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'discount_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-products_discounts-product_id-products-id', 'products_discounts', 'product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-products_discounts-discount_id-discounts-id', 'products_discounts', 'discount_id', 'discounts', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-products_discounts-discount_id-discounts-id', 'products_discounts');
        $this->dropForeignKey('fk-products_discounts-product_id-products-id', 'products_discounts');

        $this->dropTable('products_discounts');

        $this->dropTable('discounts');
    }

}
