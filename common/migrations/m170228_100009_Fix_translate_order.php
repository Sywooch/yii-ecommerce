<?php

use yii\db\Migration;

class m170228_100009_Fix_translate_order extends Migration
{
    public function up()
    {
        
$this->execute("INSERT INTO `translate_source_message` (`id`, `category`, `message`) VALUES
(234, 'shop_spec', 'Set name'),
(235, 'shop_spec', 'Product name'),
(236, 'shop_spec', 'Category name'),
(237, 'shop', 'User');");


$this->execute("INSERT INTO `translate_message` (`id`, `language`, `translation`) VALUES
(234, 'en', ''),
(234, 'ru', 'Имя Сета'),
(235, 'en', ''),
(235, 'ru', 'Название товара'),
(236, 'en', ''),
(236, 'ru', 'Имя категории'),
(237, 'en', ''),
(237, 'ru', 'Пользователь');");


    }
    }

    public function down()
    {
        echo "m170228_100009_Fix_translate_order cannot be reverted.\n";

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
