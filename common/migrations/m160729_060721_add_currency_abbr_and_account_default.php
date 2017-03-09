<?php

use yii\db\Migration;

class m160729_060721_add_currency_abbr_and_account_default extends Migration {

    public function up() {
        $this->addColumn('currencies', 'abbr', 'VARCHAR(255)');
        $this->createIndex('i-currencies-abbr', 'currencies', 'abbr', true);
        $this->addColumn('accounts', 'default', 'INTEGER(1) DEFAULT 0');
    }

    public function down() {
        $this->dropColumn('accounts', 'default');
        $this->dropColumn('currencies', 'abbr');
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
