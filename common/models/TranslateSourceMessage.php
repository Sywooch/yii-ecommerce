<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use yii\helpers\Url;
use webdoka\yiiecommerce\common\models\Lang;
use webdoka\yiiecommerce\common\models\TranslateMessage;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * This is the model class for table "{{%translate_source_message}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property TranslateMessage[] $translateMessages
 */
class TranslateSourceMessage extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%translate_source_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('shop', 'ID'),
            'category' => Yii::t('shop', 'Category'),
            'message' => Yii::t('shop', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslateMessages() {
        return $this->hasMany(TranslateMessage::className(), ['id' => 'id']);
    }

    /**
     * Returns Translates by category and product
     * @return array
     */
    public function getTranslates() {
        $data = [];

        if ($alllang = Lang::find()->orderBy('date_create')->all()) {
            foreach ($alllang as $lang) {
                $alltranslate = null;
                $alltranslate = TranslateMessage::find()->where(['and', ['id' => $this->id, 'language' => $lang->url]])->one();

                $data[] = [
                    'id' => $this->id,
                    'language' => isset($alltranslate->language) ? ($alltranslate->language) : ($lang->url),
                    'value' => isset($alltranslate->translation) ? ($alltranslate->translation) : ('')
                ];
            }
        }

        return $data;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = TranslateSourceMessage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id,]);
        $query->andFilterWhere(['like', 'message', $this->message]);
        $query->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }

}
