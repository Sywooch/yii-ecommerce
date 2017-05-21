<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;
use webdoka\yiiecommerce\common\models\TranslateMessage;

class m170521_082805_add_translate_to_products extends Migration
{

    public function safeUp()
    {
        $i18ns = [
            [
                'source' => 'Short Description',
                'translates' => [
                    'ru' => 'Краткое описание',
                    'en' => 'Short Description'
                ]
            ],
            [
                'source' => 'Description',
                'translates' => [
                    'ru' => 'Описание',
                    'en' => 'Description'
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
