<?php

use yii\db\Migration;

class m170329_063327_add_translate_profiles extends Migration
{
    public function up()
    {


        $start=276;
        
        $this->execute("INSERT INTO `translate_source_message` (`id`, `category`, `message`) VALUES
            (".$start.", 'shop', 'Profile from'),
            (".($start+1).", 'shop', 'Create'),
            (".($start+2).", 'shop', 'Update'),
            (".($start+3).", 'shop', 'Customer profile'),
            (".($start+4).", 'shop', 'Recipient profile'),
            (".($start+5).", 'shop', 'Individual'),
            (".($start+6).", 'shop', 'Legal'),
            (".($start+7).", 'shop', 'Customer'),
            (".($start+8).", 'shop', 'Recipient'),
            (".($start+9).", 'shop', 'User ID'),
            (".($start+10).", 'shop', 'Default Account ID'),
            (".($start+11).", 'shop', 'Profile name'),
            (".($start+12).", 'shop', 'Last Name'),
            (".($start+13).", 'shop', 'Legal Adress'),
            (".($start+14).", 'shop', 'Individual Adress'),
            (".($start+15).", 'shop', 'Inn'),
            (".($start+16).", 'shop', 'Phone'),
            (".($start+17).", 'shop', 'The customer and the recipient are the same?'),
            (".($start+18).", 'shop', 'Create Profiles'),
            (".($start+19).", 'shop', 'Profiles'),
            (".($start+20).", 'shop', 'Search'),
            (".($start+21).", 'shop', 'Reset'),
            (".($start+22).", 'shop', 'Delete'),
            (".($start+23).", 'shop', 'Are you sure you want to delete this item?'),
            (".($start+24).", 'shop', 'Update {modelClass}: '),
            (".($start+25).", 'shop', 'User info'),
            (".($start+26).", 'shop', 'Confirm'),
            (".($start+27).", 'shop', 'No confirm'),
            (".($start+28).", 'shop', 'Users Sttings'),
            (".($start+29).", 'shop', 'Filter Price'),          
            (".($start+30).", 'shop', 'Filter'),
            (".($start+31).", 'shop', 'Signup'),
            (".($start+32).", 'shop', 'Login'),
            (".($start+33).", 'shop', 'Select Profiles'),          
            (".($start+34).", 'shop', 'Create Profile'),
            (".($start+35).", 'shop', 'From'),          
            (".($start+36).", 'shop', 'To');
            (".($start+37).", 'shop', 'Welcome'),
            (".($start+38).", 'shop', 'Legal Name');
            ");

        $this->execute("INSERT INTO `translate_message` (`id`, `language`, `translation`) VALUES
            (".$start.", 'en', ''),
            (".$start.", 'ru', 'Формы профиля'),
            (".($start+1).", 'en', ''),
            (".($start+1).", 'ru', 'Создать'),
            (".($start+2).", 'en', ''),
            (".($start+2).", 'ru', 'Редактировать'),
            (".($start+3).", 'en', ''),
            (".($start+3).", 'ru', 'Профиль плательщика'),
            (".($start+4).", 'en', ''),
            (".($start+4).", 'ru', 'Профиль получателя'),
            (".($start+5).", 'en', ''),
            (".($start+5).", 'ru', 'Физическое лицо'),
            (".($start+6).", 'en', ''),
            (".($start+6).", 'ru', 'Юридическое лицо'),
            (".($start+7).", 'en', ''),
            (".($start+7).", 'ru', 'Плательщик'),
            (".($start+8).", 'en', ''),
            (".($start+8).", 'ru', 'Адрес доставки'),
            (".($start+9).", 'en', ''),
            (".($start+9).", 'ru', 'Пользователь'),
            (".($start+10).", 'en', ''),
            (".($start+10).", 'ru', 'Аккаунт по умолчанию'),
            (".($start+11).", 'en', ''),
            (".($start+11).", 'ru', 'Название профиля'),
            (".($start+12).", 'en', ''),
            (".($start+12).", 'ru', 'Фамилия'),
            (".($start+13).", 'en', ''),
            (".($start+13).", 'ru', 'Юридический адрес'),
            (".($start+14).", 'en', ''),
            (".($start+14).", 'ru', 'Адрес'),
            (".($start+15).", 'en', ''),
            (".($start+15).", 'ru', 'ИНН'),
            (".($start+16).", 'en', ''),
            (".($start+16).", 'ru', 'Телефон'),
            (".($start+17).", 'en', ''),
            (".($start+17).", 'ru', 'Данные плательщика совпадают с адресом доставки?'),
            (".($start+18).", 'en', ''),
            (".($start+18).", 'ru', 'Создать профили'),
            (".($start+19).", 'en', ''),
            (".($start+19).", 'ru', 'Профили'),
            (".($start+20).", 'en', ''),
            (".($start+20).", 'ru', 'Поиск'),
            (".($start+21).", 'en', ''),
            (".($start+21).", 'ru', 'Сбросить'),
            (".($start+22).", 'en', ''),
            (".($start+22).", 'ru', 'Удалить'),
            (".($start+23).", 'en', ''),
            (".($start+23).", 'ru', 'Вы уверены что хотите удалить этот эелемент?'),
            (".($start+24).", 'en', ''),
            (".($start+24).", 'ru', 'Редактировать {modelClass}: '),
            (".($start+25).", 'en', ''),
            (".($start+25).", 'ru', 'Информация о пользователе'),
            (".($start+26).", 'en', ''),
            (".($start+26).", 'ru', 'Подтверждён'),
            (".($start+27).", 'en', ''),
            (".($start+27).", 'ru', 'Не подтверждён'),
            (".($start+28).", 'en', ''),
            (".($start+28).", 'ru', 'Настройки пользователей'), 
            (".($start+29).", 'en', ''),
            (".($start+29).", 'ru', 'Фильтр по ценам'),                       
            (".($start+30).", 'en', ''),
            (".($start+30).", 'ru', 'Фильтр'),
            (".($start+31).", 'en', ''),
            (".($start+31).", 'ru', 'Регистрация'),
            (".($start+32).", 'en', ''),
            (".($start+32).", 'ru', 'Войти'), 
            (".($start+33).", 'en', ''),
            (".($start+33).", 'ru', 'Выбрать профили'),                       
            (".($start+34).", 'en', ''),
            (".($start+34).", 'ru', 'Создать профиль'), 
            (".($start+35).", 'en', ''),
            (".($start+35).", 'ru', 'Из'),                       
            (".($start+36).", 'en', ''),
            (".($start+36).", 'ru', 'В'),            
            (".($start+37).", 'en', ''),
            (".($start+37).", 'ru', 'Добро пожаловать'),
            (".($start+38).", 'en', ''),
            (".($start+38).", 'ru', 'Название фирмы');
            ");

        $this->execute("UPDATE `translate_message` SET `translation` = 'Email пользователя' WHERE `translate_message`.`id` = 256 AND `translate_message`.`language` = 'ru';");

        $this->execute("UPDATE `translate_message` SET `translation` = 'Счёт пользователя' WHERE `translate_message`.`id` = 147 AND `translate_message`.`language` = 'ru';");

        $this->execute("UPDATE `translate_message` SET `translation` = 'Счета пользователей' WHERE `translate_message`.`id` = 148 AND `translate_message`.`language` = 'ru';");
    }



    public function down()
    {
        echo "m170329_063327_add_translate_profiles cannot be reverted.\n";

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
