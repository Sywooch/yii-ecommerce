<?php

use yii\db\Migration;

class m170328_151548_cart_add_column extends Migration
{
    public function up()
    {

        $this->execute("SET FOREIGN_KEY_CHECKS = 0;");
        $this->execute("TRUNCATE `carts`;");
        $this->execute("ALTER TABLE `carts` ADD `recipient_id` INT( 11 ) NOT NULL ;");
        $this->execute("ALTER TABLE `carts` ADD INDEX ( `recipient_id` ) ;");

        $this->execute("ALTER TABLE `carts` ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY ( `recipient_id` ) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");
        $this->execute("SET FOREIGN_KEY_CHECKS = 1;");
    }


    public function down()
    {
         $this->execute("ALTER TABLE `carts` DROP FOREIGN KEY `carts_ibfk_1` ;");
        $this->dropColumn('carts', 'recipient_id');
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
