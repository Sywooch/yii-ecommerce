<?php

use yii\db\Migration;

class m170322_163028_product_storages extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `products_storages` (
      `id` int(255) NOT NULL AUTO_INCREMENT,
      `product_id` int(255) NOT NULL,
      `storage_id` int(255) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `product_id` (`product_id`),
      KEY `storage_id` (`storage_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->execute("ALTER TABLE `products_storages`
      ADD CONSTRAINT `products_storages_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
      ADD CONSTRAINT `products_storages_ibfk_2` FOREIGN KEY (`storage_id`) REFERENCES `storages` (`id`) ON DELETE CASCADE;");
    }

    public function down()
    {
        $this->dropTable('products_storages');
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
