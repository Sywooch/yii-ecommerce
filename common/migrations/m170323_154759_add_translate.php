<?php

use yii\db\Migration;

class m170323_154759_add_translate extends Migration
{
    public function up()
    {


        $start=247;
        
        $this->execute("INSERT INTO `translate_source_message` (`id`, `category`, `message`) VALUES
            (".$start.", 'shop', 'Stock'),
            (".($start+1).", 'shop', 'Total Price'),
            (".($start+2).", 'shop', 'Length'),
            (".($start+3).", 'shop', 'Width'),
            (".($start+4).", 'shop', 'Height'),
            (".($start+5).", 'shop', 'Weight'),
            (".($start+6).", 'shop', 'Deliveries locations paks'),
            (".($start+7).", 'shop', 'Region'),
            (".($start+8).", 'shop', 'State'),
            (".($start+9).", 'shop', 'Email'),
            (".($start+10).", 'shop', 'Street'),
            (".($start+11).", 'shop', 'Specify Storages'),
            (".($start+12).", 'shop', 'Delivery info'),
            (".($start+13).", 'shop', 'Delivery from'),
            (".($start+14).", 'shop', 'Delivery to'),
            (".($start+15).", 'shop', 'Pak'),
            (".($start+16).", 'shop', 'Across'),
            (".($start+17).", 'shop', 'Сharacteristics'),
            (".($start+18).", 'shop', 'Dimensions'),
            (".($start+19).", 'shop', 'Biggest city'),
            (".($start+20).", 'shop', 'State city'),
            (".($start+21).", 'shop', 'City without region'),
            (".($start+22).", 'shop', 'Choose Category'),
            (".($start+23).", 'shop', 'Paks'),
            (".($start+24).", 'shop', 'Add from exist'),
            (".($start+25).", 'shop', 'Create new'),
            (".($start+26).", 'shop', 'Storages location'),
            (".($start+27).", 'shop', 'Deliveries location'),
            (".($start+28).", 'shop', 'Logistics');
            ");

        $this->execute("INSERT INTO `translate_message` (`id`, `language`, `translation`) VALUES
            (".$start.", 'en', ''),
            (".$start.", 'ru', 'Магазин'),
            (".($start+1).", 'en', ''),
            (".($start+1).", 'ru', 'Общая цена'),
            (".($start+2).", 'en', ''),
            (".($start+2).", 'ru', 'Длинна'),
            (".($start+3).", 'en', ''),
            (".($start+3).", 'ru', 'Ширина'),
            (".($start+4).", 'en', ''),
            (".($start+4).", 'ru', 'Высота'),
            (".($start+5).", 'en', ''),
            (".($start+5).", 'ru', 'Вес'),
            (".($start+6).", 'en', ''),
            (".($start+6).", 'ru', 'Набор мест доставки'),
            (".($start+7).", 'en', ''),
            (".($start+7).", 'ru', 'Регион/Район/Область'),
            (".($start+8).", 'en', ''),
            (".($start+8).", 'ru', 'Штат'),
            (".($start+9).", 'en', ''),
            (".($start+9).", 'ru', 'Пользователь'),
            (".($start+10).", 'en', ''),
            (".($start+10).", 'ru', 'Улица'),
            (".($start+11).", 'en', ''),
            (".($start+11).", 'ru', 'Спецификация склада'),
            (".($start+12).", 'en', ''),
            (".($start+12).", 'ru', 'Информация о доставке'),
            (".($start+13).", 'en', ''),
            (".($start+13).", 'ru', 'Доставка из'),
            (".($start+14).", 'en', ''),
            (".($start+14).", 'ru', 'Доставка в'),
            (".($start+15).", 'en', ''),
            (".($start+15).", 'ru', 'Набор'),
            (".($start+16).", 'en', ''),
            (".($start+16).", 'ru', 'По всей'),
            (".($start+17).", 'en', ''),
            (".($start+17).", 'ru', 'Характеристики'),
            (".($start+18).", 'en', ''),
            (".($start+18).", 'ru', 'Габариты'),
            (".($start+19).", 'en', ''),
            (".($start+19).", 'ru', 'Большой город'),
            (".($start+20).", 'en', ''),
            (".($start+20).", 'ru', 'Областной город'),
            (".($start+21).", 'en', ''),
            (".($start+21).", 'ru', 'Город без региона'),
            (".($start+22).", 'en', ''),
            (".($start+22).", 'ru', 'Выбрать категорию'),
            (".($start+23).", 'en', ''),
            (".($start+23).", 'ru', 'Наборы'),
            (".($start+24).", 'en', ''),
            (".($start+24).", 'ru', 'Добавить в существующий'),
            (".($start+25).", 'en', ''),
            (".($start+25).", 'ru', 'Создать новый'),
            (".($start+26).", 'en', ''),
            (".($start+26).", 'ru', 'Складские места'),
            (".($start+27).", 'en', ''),
            (".($start+27).", 'ru', 'Места доставок'),
            (".($start+28).", 'en', ''),
            (".($start+28).", 'ru', 'Логистика');");
    }

    public function down()
    {
        echo "m170323_154759_add_translate cannot be reverted.\n";

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
