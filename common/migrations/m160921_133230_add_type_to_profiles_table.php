<?php

use yii\db\Migration;

class m160921_133230_add_type_to_profiles_table extends Migration
{
    public function up()
    {
        $this->addColumn('profiles', 'type', 'ENUM("individual", "legal") DEFAULT "individual"');
    }

    public function down()
    {
        $this->dropColumn('profiles', 'type');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
