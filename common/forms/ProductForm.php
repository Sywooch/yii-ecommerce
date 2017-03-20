<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Discount;
use webdoka\yiiecommerce\common\models\FeatureProduct;
use webdoka\yiiecommerce\common\models\Price;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\Feature;
use webdoka\yiiecommerce\common\models\ProductDiscount;
use webdoka\yiiecommerce\common\models\ProductPrice;
use yii\helpers\ArrayHelper;
use Yii;

class ProductForm extends Product
{

    public $_relFeatures = [];
    public $_relPrices = [];
    public $_relDiscounts = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            ['relFeatures', 'each', 'rule' => ['string'], 'skipOnEmpty' => true, 'message' => Yii::t('shop', 'Specify Feature')],
            ['relPrices', 'each', 'rule' => ['string'], 'skipOnEmpty' => true, 'message' => Yii::t('shop', 'Specify Price')],
            ['relDiscounts', 'each', 'rule' => ['integer'], 'skipOnEmpty' => true, 'message' => Yii::t('shop', 'Specify Discount')],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'relFeatures' => Yii::t('shop', 'Features'),
            'relPrices' => Yii::t('shop', 'Prices'),
            'relDiscounts' => Yii::t('shop', 'Discounts'),
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
        $this->_relFeatures = $features ?: [];
    }

    /**
     * Buffer variable for related prices
     * @return array
     */
    public function getRelPrices()
    {
        return $this->_relPrices;
    }

    /**
     * Set related prices
     * @param $types
     */
    public function setRelPrices($prices)
    {
        $this->_relPrices = $prices ?: [];
    }

    /**
     * Buffer variable for related discounts
     * @return array
     */
    public function getRelDiscounts()
    {
        return $this->_relDiscounts;
    }

    /**
     * Set related discounts
     * @param $types
     */
    public function setRelDiscounts($discounts)
    {
        $this->_relDiscounts = $discounts ?: [];
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
            $this->savePricesToRelation();
            $this->saveDiscountsToRelation();
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

    /**
     * Populating prices to relation
     */
    private function savePricesToRelation()
    {
        $prices = [];

        foreach ($this->_relPrices as $relPrice => $value) {
            if ($price = Price::findOne($relPrice)) {
                $productPrice = new ProductPrice();
                $productPrice->price_id = $price->id;
                $productPrice->value = $value;

                $prices[] = $productPrice;
            }
        }

        $this->populateRelation('productPrices', $prices);
    }

    /**
     * Populating discounts to relation
     */
    private function saveDiscountsToRelation()
    {
        $discounts = [];

        foreach ($this->_relDiscounts as $relDiscount) {
            if ($discount = Discount::findOne($relDiscount)) {
                $productDiscount = new ProductDiscount();
                $productDiscount->discount_id = $discount->id;

                $discounts[] = $productDiscount;
            }
        }

        $this->populateRelation('productDiscounts', $discounts);
    }

}
