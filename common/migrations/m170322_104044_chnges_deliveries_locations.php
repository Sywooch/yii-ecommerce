<?php

use yii\db\Migration;

class m170322_104044_chnges_deliveries_locations extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `locations` ADD `region` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `city` ;");

        $this->execute("ALTER TABLE `locations` ADD `type` TINYINT( 2 ) NOT NULL DEFAULT '0' COMMENT '0:storeges, 1:deliveres';");

        $this->createIndex('type', 'locations', 'type');

        $this->dropIndex('country', 'locations');

        $this->createIndex('country', 'locations', 'country');

        $this->execute("ALTER TABLE `locations` CHANGE `uid` `uid` VARCHAR( 255 ) NULL DEFAULT NULL;");
        $this->execute("ALTER TABLE `locations` CHANGE `city` `city` VARCHAR( 255 ) NULL DEFAULT NULL;");
        $this->execute("ALTER TABLE `locations` CHANGE `address` `address` VARCHAR( 255 ) NULL DEFAULT NULL;");
        $this->execute("ALTER TABLE `locations` CHANGE `index` `index` VARCHAR( 255 ) NULL DEFAULT NULL;");

        $this->execute("ALTER TABLE `deliveries` ADD `pak_id` INT( 255 ) NULL ;");

        $this->execute("ALTER TABLE `locations_pak_deliveries` ADD FOREIGN KEY ( `pak_id` ) REFERENCES `deliveries_locations_pak` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;");
        
        $this->execute("ALTER TABLE `locations_pak_deliveries` ADD FOREIGN KEY ( `locations_id` ) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;");
    }

    public function down()
    {

        $this->dropForeignKey('locations_pak_deliveries_ibfk_2', 'locations_pak_deliveries');
        $this->dropForeignKey('locations_pak_deliveries_ibfk_1', 'locations_pak_deliveries');
        $this->dropColumn('deliveries', 'pak_id');
        $this->execute("ALTER TABLE `locations` CHANGE `uid` `uid` VARCHAR( 255 ) NOT NULL;");
        $this->execute("ALTER TABLE `locations` CHANGE `city` `city` VARCHAR( 255 ) NOT NULL;");
        $this->execute("ALTER TABLE `locations` CHANGE `address` `address` VARCHAR( 255 ) NOT NULL;");
        $this->execute("ALTER TABLE `locations` CHANGE `index` `index` VARCHAR( 255 ) NOT NULL;");
        $this->dropIndex('type', 'locations');
        $this->dropColumn('locations', 'type');
        $this->dropColumn('locations', 'region');
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
