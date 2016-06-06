<?php

namespace webdoka\yiiecommerce\forms;

use webdoka\yiiecommerce\models\FeatureProduct;
use webdoka\yiiecommerce\models\Product;
use webdoka\yiiecommerce\models\Feature;
use yii\helpers\ArrayHelper;

class ProductForm extends Product
{
    public $_relFeatures = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            ['relFeatures', 'each', 'rule' => ['string'], 'skipOnEmpty' => true, 'message' => 'Specify Feature']
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'relFeatures' => 'Features',
        ], parent::attributeLabels());
    }

    /**
     * Buffer variable for related features of category.
     * @return array
     */
    public function getRelFeatures()
    {
        return $this->_relFeatures;
    }

    /**
     * Set related types
     * @param $types
     */
    public function setRelFeatures($features)
    {
        $this->_relFeatures = $features;
    }

    /**
     * Save relFeatures to relation
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->saveFeaturesToRelation();
            return true;
        }

        return false;
    }

    /**
     * Populating features to relation
     */
    private function saveFeaturesToRelation()
    {
        $features = [];

        foreach ($this->_relFeatures as $relFeature => $value) {
            if ($feature = Feature::findOne($relFeature)) {
                $featureProduct = new FeatureProduct();
                $featureProduct->feature_id = $feature->id;
                $featureProduct->value = $value;

                $features[] = $featureProduct;
            }
        }

        $this->populateRelation('productFeatures', $features);
    }
}