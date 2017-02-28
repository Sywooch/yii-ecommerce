<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\components\ISetPosition;
use Yii;
use webdoka\yiiecommerce\common\queries\SetQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sets".
 *
 * @property integer $id
 * @property string $name
 *
 * @property OrderItem[] $orderItems
 * @property SetProduct[] $setsProducts
 */
class Set extends ActiveRecord implements ISetPosition
{
    const LIST_SET = 'shopListSet';
    const VIEW_SET = 'shopViewSet';
    const CREATE_SET = 'shopCreateSet';
    const UPDATE_SET = 'shopUpdateSet';
    const DELETE_SET = 'shopDeleteSet';

    private $_tmpId = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'name' => Yii::t('shop', 'Name'),
        ];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getTmpId();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return 1;
    }

    /**
     * @param $quantity
     */
    public function setQuantity($quantity)
    {

    }

    /**
     * @return string
     */
    public function getTmpId()
    {
        if (!$this->_tmpId)
            $this->_tmpId = Yii::$app->security->generateRandomKey();

        return $this->_tmpId;
    }

    /**
     * Returns summary of included products
     * @return float|int
     */
    public function getRealPrice()
    {
        $summary = 0;
        $roles = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        $country = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one();

        // Summary
        foreach ($this->setsProducts as $setProduct) {
            // Get min price
            $price = Price::getMinPrice($roles, $setProduct->product_id) ?: $setProduct->product->price;

            // Price + VAT
            if ($country) {
                $price += $price * $country->tax / 100;
            }

            $summary += $price * $setProduct->quantity;
        }

        return $summary;
    }

    /**
     * @return float|int
     */
    public function getCostWithDiscounters()
    {
        $amount = $this->getRealPrice();

        // Apply discounts
        foreach ($this->discounts as $discount) {
            $delta = $amount * $discount->value / 100;
            $amount -= $delta;
        }

        return $amount;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['set_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetsProducts()
    {
        return $this->hasMany(SetProduct::className(), ['set_id' => 'id']);
    }

    /**
     * @return $this
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('setsProducts');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetsDiscounts()
    {
        return $this->hasMany(SetDiscount::className(), ['set_id' => 'id']);
    }

    /**
     * @return $this
     */
    public function getDiscounts()
    {
        return $this->hasMany(Discount::className(), ['id' => 'discount_id'])->via('setsDiscounts');
    }

    /**
     * @inheritdoc
     * @return SetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SetQuery(get_called_class());
    }

    /**
     * After save handles
     */
    public function afterSave($insert, $changedAttributes)
    {
        $relatedRecords = $this->getRelatedRecords();

        if (array_key_exists('setsProducts', $relatedRecords)) {
            $this->unlinkAll('setsProducts', true);
            foreach ($relatedRecords['setsProducts'] as $setProduct) {
                $this->link('setsProducts', $setProduct);
            }
        }

        if (array_key_exists('discounts', $relatedRecords)) {
            $this->unlinkAll('discounts', true);
            foreach ($relatedRecords['discounts'] as $discount) {
                $this->link('discounts', $discount);
            }
        }
    }
}
