<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;
use webdoka\yiiecommerce\common\models\TranslateMessage;

class m170518_042500_add_translate_to_products extends Migration
{

    public function safeUp()
    {
        $i18ns = [
            [
                'source' => 'The string must end with a number',
                'translates' => [
                    'ru' => 'Строка должна заканчиваться на число',
                    'en' => 'The string must end with a number'
                ]
            ],
            [
                'source' => 'Vendor Code',
                'translates' => [
                    'ru' => 'Артикул',
                    'en' => 'Vendor Code'
                ]
            ],
            [
                'source' => 'Variants',
                'translates' => [
                    'ru' => 'Торговые предложения',
                    'en' => 'Variants'
                ]
            ],
            [
                'source' => 'Quantity Stock',
                'translates' => [
                    'ru' => 'Количество на складе',
                    'en' => 'Quantity Stock'
                ]
            ],
            [
                'source' => 'Select',
                'translates' => [
                    'ru' => 'Выбрать',
                    'en' => 'Select'
                ]
            ],
        ];
        foreach ($i18ns as $i18n) {
            $model = new TranslateSourceMessage();
            $model->message = $i18n['source'];
            $model->category = 'shop';
            if($model->save()) {
                foreach ($i18n['translates'] as $language => $translate) {
                    $getmodel = new TranslateMessage();
                    $getmodel->id = $model->id;
                    $getmodel->language = $language;
                    $getmodel->translation = $translate;
                    $getmodel->save();
                }
            }
        }
    }

    public function safeDown()
    {
        echo "m170518_042500_add_translate_to_products.\n";

        return false;
    }
}
