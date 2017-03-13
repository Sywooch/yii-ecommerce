<?php

use yii\db\Migration;

class m170228_081131_add_language_rbak_data extends Migration
{

    public function up()
    {

        $this->execute("INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('shopCreateLang', 2, 'Create shop language', NULL, NULL, NULL, NULL),
('shopDeleteLang', 2, 'Delete shop language', NULL, NULL, NULL, NULL),
('shopListLang', 2, 'List shop language', NULL, NULL, NULL, NULL),
('shopUpdateLang', 2, 'Update shop language', NULL, NULL, NULL, NULL),
('shopViewLang', 2, 'View shop language', NULL, NULL, NULL, NULL);");


        $this->execute("INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Manager', 'shopCreateLang'),
('Manager', 'shopDeleteLang'),
('Manager', 'shopListLang'),
('Manager', 'shopUpdateLang'),
('Manager', 'shopViewLang');");
    }

    public function down()
    {
        echo "m170228_081131_add_language_rbak_data cannot be reverted.\n";

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
