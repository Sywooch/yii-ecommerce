<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Discount;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\Set;
use webdoka\yiiecommerce\common\models\SetProduct;
use yii\helpers\ArrayHelper;
use Yii;

class SetForm extends Set
{
    public $_relSetsProducts = [];
    public $_relDiscounts = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            ['relSetsProducts', 'validateSetsProducts'],
            ['relDiscounts', 'each', 'rule' => ['integer'], 'skipOnEmpty' => true, 'message' => Yii::t('shop','Specify Discounts')],
        ], parent::rules());
    }

    public function validateSetsProducts()
    {
        if (empty($this->_relSetsProducts)) {
            $this->addError('name', Yii::t('shop','Specify just one product.'));
        } else {
            foreach ($this->_relSetsProducts as $relSetProduct) {
                if (!$product = Product::findOne($relSetProduct['product_id'])) {
                    Yii::$app->session->setFlash('set-error', Yii::t('shop','Invalid product.'));
                    $this->addError('relSetsProducts', '');
                }

                if (!$relSetProduct['quantity']) {
                    Yii::$app->session->setFlash('set-error', Yii::t('shop','Quantity must be more than 1.'));
                    $this->addError('relSetsProducts', '');
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'relSetsProducts' => Yii::t('shop','Products'),
            'relDiscounts' => Yii::t('shop','Discounts'),
        ], parent::attributeLabels());
    }

    /**
     * Buffer variable for related setsProducts.
     * @return array
     */
    public function getRelSetsProducts()
    {
        return $this->_relSetsProducts;
    }

    /**
     * Set related setsProducts
     * @param $setsProducts
     */
    public function setRelSetsProducts($setsProducts)
    {
        $this->_relSetsProducts = $setsProducts;
    }

    /**
     * Buffer variable for related discounts.
     * @return array
     */
    public function getRelDiscounts()
    {
        return $this->_relDiscounts;
    }

    /**
     * Set related discounts
     * @param $discounts
     */
    public function setRelDiscounts($discounts)
    {
        $this->_relDiscounts = $discounts;
    }

    /**
     * Save relations
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->saveSetsProductsToRelation();
            $this->saveDiscountsToRelation();
            return true;
        }

        return false;
    }

    /**
     * Populating setsProducts to relation
     */
    private function saveSetsProductsToRelation()
    {
        $setsProducts = [];

        foreach ($this->_relSetsProducts as $productId =>$relSetsProduct) {
            $setProduct = new SetProduct();
            $setProduct->product_id = $relSetsProduct['product_id'];
            $setProduct->quantity = $relSetsProduct['quantity'];

            $setsProducts[$productId] = $setProduct;
        }

        $this->populateRelation('setsProducts', $setsProducts);
    }

    /**
     * Populating discounts to relation
     */
    private function saveDiscountsToRelation()
    {
        $discounts = [];

        foreach ($this->_relDiscounts as $relDiscount) {
            if ($discount = Discount::find()->where(['id' => $relDiscount])->set()->one()) {
                $discounts[] = $discount;
            }
        }

        $this->populateRelation('discounts', $discounts);
    }
}