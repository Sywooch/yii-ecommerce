<?php

use yii\db\Migration;

class m160726_094045_add_total_to_orders extends Migration
{

    public function up()
    {
        $this->addColumn('orders', 'total', 'float');
    }

    public function down()
    {
        $this->dropColumn('orders', 'total');
    }

}
