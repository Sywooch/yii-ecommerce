<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Feature;
use yii\helpers\ArrayHelper;
use Yii;

class CategoryForm extends Category
{

    public $_relFeatures = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            ['relFeatures', 'each', 'rule' => ['integer'], 'skipOnEmpty' => true, 'message' => 'Specify Feature']
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

        if (!empty($this->_relFeatures)) {

            foreach ($this->_relFeatures as $relFeature) {
                if ($feature = Feature::findOne($relFeature)) {
                    $features[] = $feature;
                }
            }

            $this->populateRelation('features', $features);
        }
    }

}
