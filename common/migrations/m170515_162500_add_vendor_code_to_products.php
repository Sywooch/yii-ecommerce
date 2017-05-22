<?php

use yii\db\Migration;

class m170515_162500_add_vendor_code_to_products extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'vendor_code', $this->string(32));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%products}}', 'vendor_code');
    }
}
