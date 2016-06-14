<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "features".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 *
 * @property FeatureCategory[] $featureCategory
 * @property FeatureProduct[] $featureProduct
 */
class Feature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureCategory()
    {
        return $this->hasMany(FeatureCategory::className(), ['feature_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureProduct()
    {
        return $this->hasMany(FeatureProduct::className(), ['feature_id' => 'id']);
    }
}