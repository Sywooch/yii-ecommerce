<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;
use webdoka\yiiecommerce\common\models\TranslateMessage;

class m170522_112638_add_translate_to_handbook_vat extends Migration
{

    public function up()
    {
        $i18ns = [
            [
                'source' => 'Percent',
                'translates' => [
                    'ru' => 'Проценты',
                    'en' => 'Percent'
                ]
            ],
            [
                'source' => 'Is Default',
                'translates' => [
                    'ru' => 'По умолчанию',
                    'en' => 'Is Default'
                ]
            ],
            [
                'source' => 'Handbook Vat',
                'translates' => [
                    'ru' => 'Справчник НДС',
                    'en' => 'Handbook Vat'
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
