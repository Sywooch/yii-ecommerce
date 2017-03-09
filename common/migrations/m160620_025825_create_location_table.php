<?php

use yii\db\Migration;

/**
 * Handles the creation for table `locations`.
 */
class m160620_025825_create_location_table extends Migration {

    public function safeUp() {
        $this->createTable('locations', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->notNull(),
            'country' => $this->string()->unique()->notNull(),
            'city' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'index' => $this->string()->notNull(),
        ]);

        $this->createIndex('i_uid', 'locations', 'uid');
        $this->createIndex('i_city', 'locations', 'city');
    }

    public function safeDown() {
        $this->dropTable('locations');
    }

}
