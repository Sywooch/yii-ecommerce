<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Delivery;
use webdoka\yiiecommerce\common\models\DeliveriDiscount;
use webdoka\yiiecommerce\common\models\DeliverieHasDiscount;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class DeliveryForm
 * @package webdoka\yiiecommerce\common\forms
 */
class DeliveryForm extends Delivery
{

    public
        $country,
        $city;
    public $_relDiscounts = [];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['country', 'city'], 'string', 'max' => 255],
            ['relDiscounts', 'each', 'rule' => ['integer'], 'skipOnEmpty' => true, 'message' => Yii::t('shop', 'Specify Discount')],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        
        return ArrayHelper::merge([
            'country' => Yii::t('shop', 'Country'),
            'city' => Yii::t('shop', 'City'),
            'street' => Yii::t('shop', 'Street'),
            'name' => Yii::t('shop', 'Name'),
            'cost' => Yii::t('shop', 'Cost'),
            'storage_id' => Yii::t('shop', 'Storage'),
            'pak_id' => Yii::t('shop', 'Deliveries locations paks'),
            'relDiscounts' => Yii::t('shop', 'Discounts'),
        ], parent::attributeLabels());

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
            $this->saveDiscountsToRelation();
            return true;
        }

        return false;
    }

    /**
     * Populating discounts to relation
     */
    private function saveDiscountsToRelation()
    {
        $discounts = [];

        foreach ($this->_relDiscounts as $relDiscount) {
            if ($discount = DeliveriDiscount::findOne($relDiscount)) {
                $productDiscount = new DeliverieHasDiscount();
                $productDiscount->discount_id = $discount->id;

                $discounts[] = $productDiscount;
            }
        }

        $this->populateRelation('deliverieHasDiscount', $discounts);
    }            


}
