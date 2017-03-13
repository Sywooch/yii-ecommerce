<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use webdoka\yiiecommerce\common\components\IPosition;
use webdoka\yiiecommerce\common\queries\ProductQuery;
use yii\db\mysql\QueryBuilder;
use yii\helpers\ArrayHelper;
use yii\di\Instance;
use yii\web\Session;

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

    private $_quantity;
    private $_optionid;
    private $_option_id;

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
            'id' => Yii::t('shop', 'ID'),
            'category_id' => Yii::t('shop', 'Category ID'),
            'unit_id' => Yii::t('shop', 'Unit'),
            'unit' => Yii::t('shop', 'Unit'),
            'name' => Yii::t('shop', 'Name'),
            'price' => Yii::t('shop', 'Default Price'),
            'prices' => Yii::t('shop', 'Default Price'),
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

        // Get min price
        $price = Price::getMinPrice($roles, $this->id) ?: $price;

        // Price + VAT
        if ($country = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one()) {
            $price += $price * $country->tax / 100;
        }

        return $price;
    }

    /**
     * @inheritdoc
     */
    public function getOptionPrice($optid)
    {
        // Default price
        $price = $this->price;
        $roles = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

        // Get min price
        $getoptprice = Price::getOptPrice($roles, $this->id, $optid);

        $pricearray = [];
        $pricemin = [];

        foreach ($getoptprice as $key => $value) {

            $pricearray[$value->product_options_id][] = $value->value;


            if (count($pricearray[$value->product_options_id]) >= 2) {

                $pricemin[$value->product_options_id] = min($pricearray[$value->product_options_id]);

            } else {

                $pricemin[$value->product_options_id] = $pricearray[$value->product_options_id];
            }

        }

        $baseprice = Price::getMinPrice($roles, $this->id) ?: $price;

        $price = $baseprice + array_sum($pricemin);

        // Price + VAT
        if ($country = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one()) {
            $price += $price * $country->tax / 100;
        }

        $detailprice = ['price' => $price, 'baseprice' => $baseprice, 'optionsprice' => array_sum($pricemin), 'detailoptionsprice' => $pricemin];

        return $detailprice;
    }

    public function getBranchOption($option_id)
    {

        $return = [];
        $return['option'] = ProductsOptions::findOne(['id' => $option_id]);
        $return['branch'] = $return['option']->parents()->all();
        return $return;
    }

    /**
     * Returns calculated cost after discounts applied
     * @param $quantity
     * @return float|int|mixed
     */
    public function getCostWithDiscounters($quantity = 1, $optionid = 0)
    {


        if ($optionid == 0 || $optionid == null) {

            $price = $this->realPrice;
        } else {

            $price = $this->getOptionPrice(explode(',', $optionid))["price"];
            //var_dump( $price );exit;
        }

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
    public function getOptid()
    {
        return $this->_optionid;
    }

    /**
     * @inheritdoc
     */
    public function setOptid($optid)
    {
        $this->_optionid = $optid;
    }

    /**
     * @inheritdoc
     */
    public function getOption_id()
    {
        return $this->_option_id;
    }

    /**
     * @inheritdoc
     */
    public function setOption_id($optid)
    {
        $this->_option_id = $optid;
    }

    /**
     * @inheritdoc
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * @inheritdoc
     */
    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;
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
    public function getProductOtionsPrices()
    {
        return $this->hasMany(ProductsOptionsPrices::className(), ['product_id' => 'id']);
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
            //->andWhere(['dimension' => Discount::SET_DIMENSION])
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
