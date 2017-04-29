<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Discount;
use webdoka\yiiecommerce\common\models\Product;
use yii\helpers\ArrayHelper;
use Yii;

class DiscountForm extends Discount
{

    public $_relProducts = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            ['relProducts', 'each', 'rule' => ['integer'], 'skipOnEmpty' => true, 'message' => Yii::t('shop', 'Specify Products')]
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'relProducts' => Yii::t('shop', 'Products'),
        ], parent::attributeLabels());
    }

    /**
     * Buffer variable for related products of category.
     * @return array
     */
    public function getRelProducts()
    {
        return $this->_relProducts;
    }

    /**
     * Set related types
     * @param $types
     */
    public function setRelProducts($products)
    {
        $this->_relProducts = $products ?: [];
    }

    /**
     * Save relProducts to relation
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
           // $this->saveProductsToRelation();
            return true;
        }

        return false;
    }

    /**
     * Populating products to relation
     */
    private function saveProductsToRelation()
    {
        $products = [];

        foreach ($this->_relProducts as $relProduct) {
            if ($product = Product::findOne($relProduct)) {
                $products[] = $product;
            }
        }

        $this->populateRelation('products', $products);
    }

}
