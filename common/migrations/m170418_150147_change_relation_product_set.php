<?php

use yii\db\Migration;

class m170418_150147_change_relation_product_set extends Migration
{
    public function up()
    {

        $this->execute("ALTER TABLE `sets_products` DROP FOREIGN KEY `fk-sets_products-product_id-products-id` ;");
        
        $this->execute("ALTER TABLE `sets_products` ADD CONSTRAINT `fk-sets_products-product_id-products-id` FOREIGN KEY ( `product_id` ) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT ;");

        $this->execute("ALTER TABLE `sets_discounts` DROP FOREIGN KEY `fk-sets_discounts-set_id-sets-id` ;");
        
        $this->execute("ALTER TABLE `sets_discounts` ADD CONSTRAINT `fk-sets_discounts-set_id-sets-id` FOREIGN KEY ( `set_id` ) REFERENCES `sets` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT ;");

        $this->execute("ALTER TABLE `sets_products` DROP FOREIGN KEY `fk-sets_products-set_id-sets-id` ;");
        
        $this->execute("ALTER TABLE `sets_products` ADD CONSTRAINT `fk-sets_products-set_id-sets-id` FOREIGN KEY ( `set_id` ) REFERENCES `sets` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT ;");        

    }

    public function down()
    {
        $this->execute("ALTER TABLE `sets_products` DROP FOREIGN KEY `fk-sets_products-product_id-products-id` ;");
        
        $this->execute("ALTER TABLE `sets_products` ADD CONSTRAINT `fk-sets_products-product_id-products-id` FOREIGN KEY ( `product_id` ) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");

        $this->execute("ALTER TABLE `sets_discounts` DROP FOREIGN KEY `fk-sets_discounts-set_id-sets-id` ;");
        
        $this->execute("ALTER TABLE `sets_discounts` ADD CONSTRAINT `fk-sets_discounts-set_id-sets-id` FOREIGN KEY ( `set_id` ) REFERENCES `sets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");
        
        $this->execute("ALTER TABLE `sets_products` DROP FOREIGN KEY `fk-sets_products-set_id-sets-id` ;");
        
        $this->execute("ALTER TABLE `sets_products` ADD CONSTRAINT `fk-sets_products-set_id-sets-id` FOREIGN KEY ( `set_id` ) REFERENCES `sets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");


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
