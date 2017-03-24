<?php

use yii\db\Migration;

class m170322_103450_add_relationtabs_deliveries_locations extends Migration
{
    public function up()
    {

        $this->execute("CREATE TABLE IF NOT EXISTS `deliveries_locations_pak` (
          `id` int(255) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `name` (`name`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");


        $this->execute("CREATE TABLE IF NOT EXISTS `locations_pak_deliveries` (
          `id` int(255) NOT NULL AUTO_INCREMENT,
          `pak_id` int(255) NOT NULL,
          `locations_id` int(255) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `pak_id` (`pak_id`),
          KEY `locations_id` (`locations_id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    }

    public function down()
    {
        $this->dropTable('deliveries_locations_pak');
        $this->dropTable('locations_pak_deliveries');
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
