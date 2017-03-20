<?php

use yii\db\Migration;

class m160717_111433_add_name_accounts extends Migration
{

    public function up()
    {
        $this->addColumn('accounts', 'name', 'VARCHAR(255) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('accounts', 'name');
    }

}
