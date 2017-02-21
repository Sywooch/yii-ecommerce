<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use yii\helpers\Url;
use webdoka\yiiecommerce\common\models\Lang;
use webdoka\yiiecommerce\common\models\TranslateMessage;

/**
 * This is the model class for table "{{%translate_source_message}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property TranslateMessage[] $translateMessages
 */
class TranslateSourceMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%translate_source_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslateMessages()
    {
        return $this->hasMany(TranslateMessage::className(), ['id' => 'id']);
    }


    /**
     * Returns Translates by category and product
     * @return array
     */
    public function getTranslates()
    {
        $data = [];

        if ($alllang = Lang::find()->orderBy('date_create')->all()) {
            foreach ($alllang as $lang) {
                $alltranslate = null;
                $alltranslate = TranslateMessage::find()->where(['and',['id'=>$this->id,'language'=>$lang->url]])->one();
 
                    $data[] = [
                    'id' => $this->id,
                    'language' => isset($alltranslate->language)?($alltranslate->language):($lang->url),
                    'value' => isset($alltranslate->translation)?($alltranslate->translation):('')
                    ];
          }
      }

      return $data;
  }


}
