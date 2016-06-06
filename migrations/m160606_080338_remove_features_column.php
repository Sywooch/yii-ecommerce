<?php

use yii\db\Migration;

class m160606_080338_remove_features_column extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('products', 'features');
    }

    public function safeDown()
    {
        return false;
    }
}
