<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\components\IPosition;
use webdoka\yiiecommerce\common\queries\ProductQuery;
use Yii;
use yii\db\mysql\QueryBuilder;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property double $price
 * @property integer $unit_id
 *
 * @property OrderItem[] $orderItems
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord implements IPosition
{
    const LIST_PRODUCT = 'shopListProduct';
    const VIEW_PRODUCT = 'shopViewProduct';
    const CREATE_PRODUCT = 'shopCreateProduct';
    const UPDATE_PRODUCT = 'shopUpdateProduct';
    const DELETE_PRODUCT = 'shopDeleteProduct';
    
    private $quantity;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'unit_id'], 'integer'],
            [['name', 'price', 'unit_id'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'unit_id' => 'Unit',
            'name' => 'Name',
            'price' => 'Default Price',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @inheritdoc
     */
    public function getRealPrice()
    {
        // Default price
        $price = $this->price;
        $roles = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

        return Price::getMinPrice($roles, $this->id) ?: $price;
    }

    /**
     * Returns calculated cost after discounts applied
     * @param $quantity
     * @return float|int|mixed
     */
    public function getCostWithDiscounters($quantity)
    {
        $price = $this->realPrice;
        $discounts = $this->availableDiscounts;

        foreach ($discounts as $discount) {
            if ($discount->dimension == Discount::FIXED_DIMENSION) {
                $delta = $discount->value;
            } else {
                $delta = $price * $discount->value / 100;
            }

            if ($discount->count) {
                $price -= $discount->count <= $quantity ? $delta : 0;
            } else {
                $price -= $delta;
            }
        }

        return $price * $quantity;
    }

    /**
     * @inheritdoc
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @inheritdoc
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Returns unit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPrices()
    {
        return $this->hasMany(ProductPrice::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['id' => 'price_id'])->via('productPrices');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricesWithValues()
    {
        $data = [];

        $prices = Price::find()->all();
        foreach ($prices as $price) {
            $productPrice = ProductPrice::find()->where([
                'product_id' => $this->id,
                'price_id' => $price->id,
            ])->one();

            $data[] = [
                'id' => $price->id,
                'label' => $price->label,
                'value' => $productPrice ? $productPrice->value : ''
            ];
        }

        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Returns product features with source features
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFullFeatures()
    {
        return $this->hasMany(FeatureProduct::className(), ['product_id' => 'id'])->with('feature');
    }

    /**
     * Return CartProduct list
     * @return \yii\db\ActiveQuery
     */
    public function getCartProducts()
    {
        return $this->hasMany(CartProduct::className(), ['cart_id' => 'id']);
    }

    /**
     * Returns product features
     * @return \yii\db\ActiveQuery
     */
    public function getProductFeatures()
    {
        return $this->hasMany(FeatureProduct::className(), ['product_id' => 'id']);
    }

    /**
     * Returns product discounts
     * @return \yii\db\ActiveQuery
     */
    public function getProductDiscounts()
    {
        return $this->hasMany(ProductDiscount::className(), ['product_id' => 'id']);
    }

    /**
     * Returns discounts
     * @return \yii\db\ActiveQuery
     */
    public function getDiscounts()
    {
        return $this->hasMany(Discount::className(), ['id' => 'discount_id'])
            ->via('productDiscounts');
    }

    /**
     * Returns features by category and product
     * @return array
     */
    public function getFeaturesWithCategories()
    {
        $data = [];

        if ($category = Category::find()->where(['id' => $this->category_id])->one()) {
            foreach ($category->features as $feature) {
                $featureProduct = FeatureProduct::find()->where([
                    'feature_id' => $feature->id,
                    'product_id' => $this->id,
                ])->one();

                $data[] = [
                    'id' => $feature->id,
                    'name' => $feature->name,
                    'value' => $featureProduct ? $featureProduct->value : ''
                ];
            }
        }

        return $data;
    }

    /**
     * Returns discounts inline
     * @return string
     */
    public function getDiscountImplode()
    {
        $discountNames = [];

        foreach ($this->discounts as $discount) {
            $discountNames[] = $discount->name;
        }

        return implode(', ', $discountNames);
    }

    /**
     * Returns available discounts
     * @return array|Discount[]
     */
    public function getAvailableDiscounts()
    {
        $productDiscountIDs = $this->getProductDiscounts()->select('discount_id')->column();

        return Discount::find()
            ->andWhere(['id' => $productDiscountIDs])
            ->available()
            ->all();
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /**
     * After save get related records, and unlink/link them if it needs.
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $relatedRecords = $this->getRelatedRecords();

        if (array_key_exists('productFeatures', $relatedRecords)) {
            $this->unlinkAll('productFeatures', true);
            foreach ($relatedRecords['productFeatures'] as $feature) {
                $this->link('productFeatures', $feature);
            }
        }

        if (array_key_exists('productPrices', $relatedRecords)) {
            $this->unlinkAll('productPrices', true);
            foreach ($relatedRecords['productPrices'] as $price) {
                $this->link('productPrices', $price);
            }
        }

        if (array_key_exists('productDiscounts', $relatedRecords)) {
            $this->unlinkAll('productDiscounts', true);
            foreach ($relatedRecords['productDiscounts'] as $discount) {
                $this->link('productDiscounts', $discount);
            }
        }
    }
}
