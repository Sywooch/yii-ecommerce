<?php

use yii\db\Migration;

class m170522_114928_create_manufacturer_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%manufacturer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'description' => $this->text(),
            'logo' => $this->string(64),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%manufacturer}}');
    }
}
