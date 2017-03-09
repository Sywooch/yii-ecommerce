<?php

use yii\db\Migration;

class m160810_051806_add_label_payment_type extends Migration {

    public function up() {
        $this->addColumn('payment_types', 'label', 'VARCHAR(255) NOT NULL');
    }

    public function down() {
        $this->dropColumn('payment_types', 'label');
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
