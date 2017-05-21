<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;
use webdoka\yiiecommerce\common\models\TranslateMessage;

class m170521_082105_add_description_to_products extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'short_description', $this->string(512));
        $this->addColumn('{{%products}}', 'description', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%products}}', 'short_description');
        $this->dropColumn('{{%products}}', 'description');
    }
}
