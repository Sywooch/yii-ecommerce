<?php

use yii\db\Migration;
use yii\db\Schema;

class m170217_110526_multilanguage extends Migration
{
public function safeUp()
{
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    }

    $this->createTable('{{%lang}}', [
        'id' => Schema::TYPE_PK,
        'url' => Schema::TYPE_STRING . '(255) NOT NULL',
        'local' => Schema::TYPE_STRING . '(255) NOT NULL',
        'name' => Schema::TYPE_STRING . '(255) NOT NULL',
        'default' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
        'date_update' => Schema::TYPE_INTEGER . ' NOT NULL',
        'date_create' => Schema::TYPE_INTEGER . ' NOT NULL',
    ], $tableOptions);

    $this->batchInsert('lang', ['url', 'local', 'name', 'default', 'date_update', 'date_create'], [
        ['en', 'en-EN', 'English', 0, time(), time()],
        ['ru', 'ru-RU', 'Русский', 1, time(), time()],
    ]);


    $this->createTable('{{%translate_source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(),
            'message' => $this->text(),
        ], $tableOptions);

    $this->createTable('{{%translate_message}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

    $this->addPrimaryKey('pk_translate_message_id_language', '{{%translate_message}}', ['id', 'language']);
    $this->addForeignKey('fk_translate_message_translate_source_message', '{{%translate_message}}', 'id', '{{%translate_source_message}}', 'id', 'CASCADE', 'RESTRICT');
    $this->createIndex('idx_translate_source_message_category', '{{%translate_source_message}}', 'category');
    $this->createIndex('idx_translate_message_language', '{{%translate_message}}', 'language');



}

public function safeDown()
{
    $this->dropTable('{{%lang}}');
    $this->dropForeignKey('fk_translate_message_translate_source_message', '{{%translate_message}}');
    $this->dropTable('{{%translate_message}}');
    $this->dropTable('{{%translate_source_message}}');
}
}
