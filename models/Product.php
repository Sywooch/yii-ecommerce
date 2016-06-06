<?php

namespace webdoka\yiiecommerce\models;

use webdoka\yiiecommerce\components\IPosition;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property double $price
 *
 * @property OrderItem[] $orderItems
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord implements IPosition
{
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
            [['category_id'], 'integer'],
            [['name', 'price'], 'required'],
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
            'name' => 'Name',
            'price' => 'Price',
        ];
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
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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
     * Returns product features with source features
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFullFeatures()
    {
        return $this->hasMany(FeatureProduct::className(), ['product_id' => 'id'])->with('feature');
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
    }
}
