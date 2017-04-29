<?php

use yii\db\Migration;

class m170328_164135_order_add_column extends Migration
{
    public function up()
    {

        $this->execute("ALTER TABLE `orders` ADD `recipient_id` INT( 11 ) NOT NULL ;");
        $this->execute("ALTER TABLE `orders` ADD INDEX ( `recipient_id` ) ;");
        $this->execute("SET FOREIGN_KEY_CHECKS = 0;");
        $this->execute("ALTER TABLE `orders` ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY ( `recipient_id` ) REFERENCES `webdoka_yiishop`.`profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");
        $this->execute("SET FOREIGN_KEY_CHECKS = 1;");
    }

    public function down()
    {
         $this->execute("ALTER TABLE `carts` DROP FOREIGN KEY `order_ibfk_1` ;");
        $this->dropColumn('orders', 'recipient_id');
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
