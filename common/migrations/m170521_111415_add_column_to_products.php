<?php

use yii\db\Migration;

class m170521_111415_add_column_to_products extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'fictitious_price', $this->money(10,2));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%products}}', 'fictitious_price');
    }
}
