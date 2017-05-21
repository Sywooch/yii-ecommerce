<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;
use webdoka\yiiecommerce\common\models\TranslateMessage;

class m170521_111435_add_translate_to_products extends Migration
{
    public function up()
    {
        $i18ns = [
            [
                'source' => 'Fictitious price',
                'translates' => [
                    'ru' => 'Фиктивная цена',
                    'en' => 'Fictitious price'
                ]
            ],
            [
                'source' => 'Note Fictitious Price for input in backend',
                'translates' => [
                    'ru' => 'Если в этом поле указана цена, то она будет отображаться возле реальной цены зачеркнутой',
                    'en' => 'If the price is indicated in this field, then it will be displayed near the actual strikeout price'
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
        echo "m170521_111435_add_translate_to_products cannot be reverted.\n";

        return false;
    }
}
