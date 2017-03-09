<?php

use yii\db\Migration;

class m170207_145138_add_products_options_tree extends Migration {

    public function up() {
        $this->createTable('{{%products_options}}', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function down() {
        $this->dropTable('{{%products_options}}');
    }

}
