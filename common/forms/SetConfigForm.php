<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Set;
use webdoka\yiiecommerce\common\models\SetProduct;
use yii\helpers\ArrayHelper;
use Yii;

class SetConfigForm extends Set
{
    public $_relSetsProducts = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            ['relSetsProducts', 'validateSetsProducts'],
        ], parent::rules());
    }

    public function validateSetsProducts()
    {
        foreach ($this->_relSetsProducts as $i => $relSetProduct) {
            if (!$setProduct = SetProduct::find()->where([
                'set_id' => $relSetProduct['set_id'],
                'product_id' => $relSetProduct['product_id']
            ])->one()) {
                $this->addError('relSetsProducts[' . $i . '][set_id]', 'SetProduct not found.');
            } else {
                if ($setProduct->quantity > $relSetProduct['quantity']) {
                    $this->addError('relSetsProducts[' . $i . '][quantity]', 'Quantity must be equal or more then ' . $setProduct->quantity . '.');
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
            'relSetsProducts' => 'Products',
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
}