<?php

namespace webdoka\yiiecommerce\common\components;

use yii\web\UrlManager;
use webdoka\yiiecommerce\common\models\Lang;

class LangUrlManager extends UrlManager {

    public function createUrl($params) {
        if (isset($params['lang_id'])) {
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = Lang::findOne($params['lang_id']);
            if ($lang === null) {
                $lang = Lang::getDefaultLang();
            }
            unset($params['lang_id']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::getCurrent();
        }
        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        if ($lang->url == Lang::getDefaultLang()->url) {

            return $url;
        }
        //Добавляем к URL префикс - буквенный идентификатор языка
        if ($url == '/') {
            return '/' . $lang->url;
        } else {
            return '/' . $lang->url . $url;
        }
    }

}
