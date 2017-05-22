<?php
use yii\db\Migration;

class m170522_102822_create_handbook_vat_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%handbook_vat}}', [
            'id' => $this->primaryKey(),
            'percent' => $this->integer(3),
            'isDefault' => $this->boolean(),
        ]);
        Yii::$app->db->createCommand()->batchInsert('{{%handbook_vat}}', ['id','percent','isDefault'], [
            [1, 0, true],
            [2, 18, false],
            [3, 20, false],
            [4, 25, false],
            ])->execute();
    }

    public function safeDown()
    {
        $this->dropTable('{{%handbook_vat}}');
    }
}
