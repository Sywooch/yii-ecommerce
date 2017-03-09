<?php

use yii\db\Migration;

/**
 * Handles the creation for table `storage`.
 */
class m160620_064342_create_storage extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('storages', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'location_id' => $this->integer()->notNull(),
            'schedule' => $this->text()->notNull(),
            'phones' => $this->string(),
            'email' => $this->string(),
            'icon' => $this->string(),
        ]);

        $this->addForeignKey('fk-storages-location_id-locations-id', 'storages', 'location_id', 'locations', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('storages');
    }

}
