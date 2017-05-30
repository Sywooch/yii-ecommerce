<?php
namespace webdoka\yiiecommerce\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class ProductsVariants extends \yii\db\ActiveRecord
{
    private $_values;

    public static function tableName()
    {
        return '{{%products_variants}}';
    }

    public function rules()
    {
        return [
            [['product_id', 'price', 'vendor_code',], 'required'],
            [['vendor_code'], 'unique', 'targetAttribute' => ['product_id', 'vendor_code'], 'message' => 'Артикул должен быть уникальным'],
            [['product_id', 'quantity_stock', 'vendor_code'], 'integer'],
            [['price'], 'number', 'numberPattern' => '/^[0-9]{1,10}(\.[0-9]{0,2})?$/'],
            [['fields', 'values'], 'safe'],
        ];
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => function() {
                    return (new \DateTime('now'))->format('Y-m-d H:i:s');
                }
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'price' => Yii::t('shop', 'Default Price'),
            'quantity_stock' => Yii::t('shop', 'Quantity Stock'),
            'vendor_code' => Yii::t('shop', 'Vendor Code'),
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getValues()
    {
        $values = [];
        $productsVariantsValue = $this->productsVariantsValue;
        return ArrayHelper::map($productsVariantsValue, 'products_options_id', 'products_value_id');
    }

    public function setValues($value)
    {
        $this->_values = $value;
    }

    public function getProductsVariantsValue()
    {
        return $this->hasMany(ProductsVariantsValue::className(), ['products_variants_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        foreach ($this->_values as $key => $value) {
            if ($value == null) {
                continue;
            }
            $model = ProductsVariantsValue::find()
                ->where(['products_variants_id' => $this->id])
                ->andWhere(['products_options_id' => $key])
                ->one();
            if ($model == null) {
                $model = new ProductsVariantsValue();
                $model->products_variants_id = $this->id;
            }
            $model->products_options_id = $key;
            $model->products_value_id = $value;
            $model->save();
        }

    }

    public static function getOptions($productId)
    {
        $options = ProductsOptionsPrices::find()
            ->where(['=', "product_id", $productId])
            ->andWhere(['status' => 1])
            ->groupBy('product_options_id')
            ->all();

        foreach ($options as $option) {
            $node = ProductsOptions::findOne(['id' => $option->productOptions->id]);
            while (true) {
                $t = $node->children(1)->one();
                if($t == null) {
                    break;
                }
                $node = $t;
            }
            if ($node == null) continue;
            $parent = $node->parents(1)->one();
            $result[$parent->id] = [
                'contentOptions' => ['id' => $parent->id],
                'label' => $parent->name,
                'format' =>'html',
                'value' => function ($model, $key, $index, $column) {
                    if(empty($model->values) or empty($model->values[$column->contentOptions['id']])) {
                        return '<span class="not-set">' . Yii::t('yii', '(not set)') . '</span>';
                    }
                    $t = $model->values[$column->contentOptions['id']];
                    return ProductsOptions::findOne(['id' => $t])->name;
                }
            ];
        }
        return  $result;
    }

    public static function getVariants($id)
    {
        $root = ProductsOptions::findOne(['id' => $id]);
        $children = $root->children(1)->all();
        return ArrayHelper::map($children, 'id', 'name');
    }

}
