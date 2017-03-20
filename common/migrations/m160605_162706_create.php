<?php

use yii\db\Migration;

class m160605_162706_create extends Migration
{

    public function safeUp()
    {
        $this->createTable('features', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()
        ]);

        $this->createTable('features_categories', [
            'id' => $this->primaryKey(),
            'feature_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('fk-features_categories-feature_id', 'features_categories', 'feature_id', 'features', 'id', 'CASCADE');
        $this->addForeignKey('fk-features_categories-category_id', 'features_categories', 'category_id', 'categories', 'id', 'CASCADE');

        $this->createTable('features_products', [
            'id' => $this->primaryKey(),
            'feature_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'value' => $this->string()
        ]);

        $this->addForeignKey('fk-features_products-feature_id', 'features_products', 'feature_id', 'features', 'id', 'CASCADE');
        $this->addForeignKey('fk-features_products-product_id', 'features_products', 'product_id', 'products', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('features_products');
        $this->dropTable('features_categories');
        $this->dropTable('features');
    }

}
