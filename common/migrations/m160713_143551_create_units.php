<?php

use yii\db\Migration;

/**
 * Handles the creation for table `units`.
 */
class m160713_143551_create_units extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('units', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addColumn('products', 'unit_id', 'integer not null');

        $this->addForeignKey('fk-products-unit_id-units-id', 'products', 'unit_id', 'units', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-products-unit_id-units-id', 'products');
        $this->dropTable('units');
    }
}
