<?php

use yii\db\Migration;

class m170317_082051_add_paypal_type_pay extends Migration
{
    public function up()
    {

        $this->batchInsert('payment_types', ['name', 'label'], [
            ['PayPal', 'PayPal'],
        ]);
    }

    public function down()
    {
        echo "m170317_082051_add_paypal_type_pay cannot be reverted.\n";

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
