<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $date_update
 * @property integer $date_create
 */
class Lang extends \yii\db\ActiveRecord
{

    const LIST_LANG = 'shopListLang';
    const VIEW_LANG = 'shopViewLang';
    const CREATE_LANG = 'shopCreateLang';
    const UPDATE_LANG = 'shopUpdateLang';
    const DELETE_LANG = 'shopDeleteLang';

    //Переменная, для хранения текущего объекта языка
    static $current = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'name', 'date_update', 'date_create'], 'required'],
            [['default', 'date_update', 'date_create'], 'integer'],
            [['url', 'local', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'url' => Yii::t('shop', 'Url'),
            'local' => Yii::t('shop', 'Local'),
            'name' => Yii::t('shop', 'Name'),
            'default' => Yii::t('shop', 'Default'),
            'date_update' => Yii::t('shop', 'Date Update'),
            'date_create' => Yii::t('shop', 'Date Create'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }
    /**
     * @return array|null|\yii\db\ActiveRecord
     */
//Получение текущего объекта языка
    static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

//Установка текущего объекта языка и локаль пользователя
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->local;
    }

//Получения объекта языка по умолчанию
    static function getDefaultLang()
    {
        return Lang::find()->where('`default` = :default', [':default' => 1])->one();
    }

    static function getLangName($code)
    {
        return Lang::find()->where('`url` = :code', [':code' => $code])->one()->name;
    }

//Переназначение языка по умолчанию
    static function updateDefaultLang($id)
    {
        self::updateAll(['default' => 0]);

        $model = Lang::findOne($id);

        $model->default = 1;

        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }

//Получения объекта языка по буквенному идентификатору
    static function getLangByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $language = Lang::find()->where('url = :url', [':url' => $url])->one();
            if ($language === null) {
                return null;
            } else {
                return $language;
            }
        }
    }

}
