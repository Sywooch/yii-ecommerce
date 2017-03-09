<?php

use yii\db\Migration;

class m160726_130845_create_countries_with_taxes extends Migration {

    public function up() {
        $this->createTable('countries', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'abbr' => $this->string()->notNull()->unique(),
            'exists_tax' => $this->integer()->defaultValue(0),
            'tax' => $this->float(),
        ]);

        $countries = json_decode(file_get_contents('http://country.io/names.json'), true);

        foreach ($countries as $abbr => $name) {
            $this->insert('countries', [
                'name' => $name,
                'abbr' => $abbr,
            ]);
        }

        $this->addColumn('orders', 'country', 'VARCHAR(255) NOT NULL');
        $this->addColumn('orders', 'tax', 'FLOAT DEFAULT NULL');
    }

    public function down() {
        $this->dropColumn('orders', 'country');
        $this->dropColumn('orders', 'tax');

        $this->dropTable('countries');
    }

}
