<?php

use yii\db\Migration;

class m170228_051718_multilanguage_dynamic_text extends Migration
{
    public function up()
    {

$this->execute("CREATE TABLE IF NOT EXISTS `translate_dynamic_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(10) NOT NULL,
  `modelID` varchar(255) NOT NULL,
  `itemID` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_description` text,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`,`modelID`,`itemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

    }


    public function down()
    {
        $this->dropTable('translate_dynamic_text');
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
