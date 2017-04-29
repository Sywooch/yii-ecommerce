<?php

use yii\db\Migration;

class m170331_061105_update_table_profiles extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `profiles`
            ADD `profile_name` VARCHAR( 255 ) NOT NULL , 
            ADD `name` VARCHAR( 255 ) NOT NULL ,
            ADD `ur_name` VARCHAR( 255 ) NOT NULL ,
            ADD `last_name` VARCHAR( 255 ) NULL ,
            ADD `legal_adress` VARCHAR( 255 ) NULL ,
            ADD `country` VARCHAR( 255 ) NOT NULL ,
            ADD `region` VARCHAR( 255 ) NOT NULL ,
            ADD `city` VARCHAR( 255 ) NOT NULL ,
            ADD `individual_adress` VARCHAR( 255 ) NOT NULL ,
            ADD `inn` VARCHAR( 255 ) NULL ,
            ADD `phone` VARCHAR( 255 ) NOT NULL ,
            ADD `status` TINYINT( 2 ) NOT NULL DEFAULT '1',
            ADD `parent_profile` INT( 11 )  NULL;");

        $this->execute("ALTER TABLE `profiles` ADD INDEX ( `parent_profile` ) ;");

        $this->execute("ALTER TABLE `profiles` ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY ( `parent_profile` ) REFERENCES `profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;");

    }

    public function down()
    {
        $this->execute("ALTER TABLE `profiles` DROP FOREIGN KEY `profiles_ibfk_1` ;");
        $this->dropColumn('profiles', 'parent_profile');
        $this->dropColumn('profiles', 'status');
        $this->dropColumn('profiles', 'phone');
        $this->dropColumn('profiles', 'inn');
        $this->dropColumn('profiles', 'individual_adress');
        $this->dropColumn('profiles', 'city');
        $this->dropColumn('profiles', 'region');
        $this->dropColumn('profiles', 'country');
        $this->dropColumn('profiles', 'legal_adress');
        $this->dropColumn('profiles', 'last_name');
        $this->dropColumn('profiles', 'ur_name');
        $this->dropColumn('profiles', 'name');
        $this->dropColumn('profiles', 'profile_name');
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
