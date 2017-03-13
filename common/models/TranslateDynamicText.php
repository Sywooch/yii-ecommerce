<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\queries\TranslateDynamicTextQuery;

/**
 * This is the model class for table "translate_dynamic_text".
 *
 * @property integer $id
 * @property string $lang
 * @property string $modelID
 * @property integer $itemID
 * @property string $name
 * @property string $short_description
 * @property string $description
 */
class TranslateDynamicText extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translate_dynamic_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang', 'modelID', 'itemID'], 'required'],
            [['itemID'], 'integer'],
            [['short_description', 'description'], 'string'],
            [['lang'], 'string', 'max' => 10],
            [['modelID'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang' => Yii::t('app', 'Lang'),
            'modelID' => Yii::t('app', 'Model ID'),
            'itemID' => Yii::t('app', 'Item ID'),
            'name' => Yii::t('app', 'Name'),
            'short_description' => Yii::t('app', 'Short Description'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return TranslateDynamicTextQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TranslateDynamicTextQuery(get_called_class());
    }

}
