<?php

use yii\db\Migration;

/**
 * Handles the creation for table `currencies`.
 */
class m160713_122210_create_currencies extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('currencies', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'symbol' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('currencies');
    }
}
