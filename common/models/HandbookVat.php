<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

class HandbookVat extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'handbook_vat';
    }

    public function rules()
    {
        return [
            [['percent'], 'integer'],
            [['isDefault'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop','ID'),
            'percent' => Yii::t('shop', 'Percent'),
            'isDefault' => Yii::t('shop', 'Is Default'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if($this->isDefault) {
                HandbookVat::updateAll(['isDefault'=> false]); 
            }

            return true;
        }
        return false;
    }
}
