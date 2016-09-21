<?php

use yii\db\Migration;

class m160921_134752_add_profile_type_to_properties_table extends Migration
{
    public function up()
    {
        $this->addColumn('properties' , 'profile_type', 'ENUM("individual", "legal") DEFAULT "individual"');
    }

    public function down()
    {
        $this->dropColumn('properties' , 'profile_type');
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
