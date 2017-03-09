<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "features_categories".
 *
 * @property integer $id
 * @property integer $feature_id
 * @property integer $category_id
 *
 * @property Category $category
 * @property Feature $feature
 */
class FeatureCategory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'features_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['feature_id', 'category_id'], 'required'],
            [['feature_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['feature_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('shop', 'ID'),
            'feature_id' => Yii::t('shop', 'Feature ID'),
            'category_id' => Yii::t('shop', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature() {
        return $this->hasOne(Feature::className(), ['id' => 'feature_id']);
    }

}
