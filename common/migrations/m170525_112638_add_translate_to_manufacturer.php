<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;
use webdoka\yiiecommerce\common\models\TranslateMessage;

class m170525_112638_add_translate_to_manufacturer extends Migration
{

    public function up()
    {
        $i18ns = [
            [
                'source' => 'Manufacturer',
                'translates' => [
                    'ru' => 'Производитель',
                    'en' => 'Manufacturer'
                ]
            ],
            [
                'source' => 'Logo',
                'translates' => [
                    'ru' => 'Логотип',
                    'en' => 'Logo'
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

    public function down()
    {
        echo "m170522_112638_add_translate_to_handbook_vat cannot be reverted.\n";

        return true;
    }

}
