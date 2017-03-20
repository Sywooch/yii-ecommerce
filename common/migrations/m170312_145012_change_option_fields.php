<?php

use yii\db\Migration;

class m170312_145012_change_option_fields extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%carts_products}}', 'option_id');
        $this->dropColumn('{{%order_items}}', 'option_id');
        $this->addColumn('{{%carts_products}}', 'option_id', $this->string());
        $this->addColumn('{{%order_items}}', 'option_id', $this->string());
    }

    public function down()
    {
        echo "m170312_145012_change_option_fields cannot be reverted.\n";

        return false;
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
