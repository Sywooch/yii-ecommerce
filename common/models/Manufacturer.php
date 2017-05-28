<?php
namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\filestorage\components\AttachmentValidator;
use webdoka\filestorage\models\FileStorage;

class Manufacturer extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%manufacturer}}';
    }

    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 64],
            [['logo'], AttachmentValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'name' => Yii::t('shop', 'Name'),
            'description' => Yii::t('shop', 'Description'),
            'logo' => Yii::t('shop', 'Logo'),
        ];
    }

    public function getLogoImg()
    {
        return $this->logoFile->directLink;
    }

    public function getLogoFile()
    {
        return $this->hasOne(FileStorage::className(), ['id' => 'logo']);
    }
}
