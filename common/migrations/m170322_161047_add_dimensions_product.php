<?php

use yii\db\Migration;

class m170322_161047_add_dimensions_product extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `products` ADD `length` INT( 255 ) NULL ;");
        $this->execute("ALTER TABLE `products` ADD `width` INT( 255 ) NULL ;");
        $this->execute("ALTER TABLE `products` ADD `height` INT( 255 ) NULL ;");
        $this->execute("ALTER TABLE `products` ADD `weight` INT( 255 ) NULL ;");
    }

    public function down()
    {
        $this->dropColumn('products', 'weight');
        $this->dropColumn('products', 'height');
        $this->dropColumn('products', 'width');
        $this->dropColumn('products', 'length');
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
