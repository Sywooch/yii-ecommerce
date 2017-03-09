<?php

use yii\db\Migration;

/**
 * Handles the creation for table `delivery`.
 */
class m160620_064350_create_delivery extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('deliveries', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'cost' => $this->float()->notNull(),
            'storage_id' => $this->integer()->defaultValue(null),
        ]);

        $this->addForeignKey('fk-deliveries-storage_id-storages-id', 'deliveries', 'storage_id', 'storages', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('deliveries');
    }

}
