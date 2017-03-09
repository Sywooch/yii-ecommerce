<?php

use yii\db\Migration;

class m170207_183515_widget_column_products_options extends Migration {

    public function safeUp() {
        $this->addColumn('{{%products_options}}', 'icon', $this->string(255));
        $this->addColumn('{{%products_options}}', 'icon_type', $this->smallInteger(1)->notNull()->defaultValue(1));
        $this->addColumn('{{%products_options}}', 'active', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%products_options}}', 'selected', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('{{%products_options}}', 'disabled', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('{{%products_options}}', 'readonly', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('{{%products_options}}', 'visible', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%products_options}}', 'collapsed', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('{{%products_options}}', 'movable_u', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%products_options}}', 'movable_d', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%products_options}}', 'movable_l', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%products_options}}', 'movable_r', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%products_options}}', 'removable', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%products_options}}', 'removable_all', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('{{%products_options}}', 'root', $this->integer());
        $this->addColumn('{{%products_options}}', 'lvl', $this->smallInteger(5)->notNull());

        $this->createIndex('tree_NK1', '{{%products_options}}', 'root');
        $this->createIndex('tree_NK2', '{{%products_options}}', 'lft');
        $this->createIndex('tree_NK3', '{{%products_options}}', 'rgt');
        $this->createIndex('tree_NK4', '{{%products_options}}', 'lvl');
        $this->createIndex('tree_NK5', '{{%products_options}}', 'active');
        $this->createIndex('tree_NK6', '{{%products_options}}', 'id');
    }

    public function safeDown() {
        $this->dropColumn('{{%products_options}}', 'icon');
        $this->dropColumn('{{%products_options}}', 'icon_type');
        $this->dropColumn('{{%products_options}}', 'active');
        $this->dropColumn('{{%products_options}}', 'selected');
        $this->dropColumn('{{%products_options}}', 'disabled');
        $this->dropColumn('{{%products_options}}', 'readonly');
        $this->dropColumn('{{%products_options}}', 'visible');
        $this->dropColumn('{{%products_options}}', 'collapsed');
        $this->dropColumn('{{%products_options}}', 'movable_u');
        $this->dropColumn('{{%products_options}}', 'movable_d');
        $this->dropColumn('{{%products_options}}', 'movable_l');
        $this->dropColumn('{{%products_options}}', 'movable_r');
        $this->dropColumn('{{%products_options}}', 'removable');
        $this->dropColumn('{{%products_options}}', 'removable_all');
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
