<?php

use yii\db\Migration;

class m170313_143855_city_add extends Migration
{
    public function up()
    {

  if ($this->db->schema->getTableSchema('cities', true) !== null) {
   $this->dropTable('cities');
}      

$this->execute("CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `region` varchar(255) NOT NULL,
  `biggest_city` tinyint(1) DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  KEY `region` (`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");



$data = file_get_contents(__DIR__ . '/data/city.sql'); //read the file
$convert = explode("),", $data); //create array separate by new line

for ($i=0;$i<count($convert);$i++) 
{
    $this->execute("INSERT INTO `cities` (`id`, `country_id`, `city`, `state`, `region`, `biggest_city`)
VALUES " . $convert[$i] . ");");

}

$this->execute("ALTER TABLE `cities` ADD INDEX ( `country_id` ) ;");
$this->execute("ALTER TABLE `cities` ADD INDEX ( `city` ) ;");


    }

    public function down()
    {
     $this->dropTable('cities');
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
