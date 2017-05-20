<?php
namespace webdoka\yiiecommerce\common\models;

use Yii;

class ProductsVariantsValue extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%products_variants_value}}';
    }


    public function rules()
    {
        return [
            [['products_variants_id', 'products_options_id'], 'required'],
            [['products_variants_id', 'products_options_id'], 'integer'],
            [['products_options_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsOptions::className(), 'targetAttribute' => ['products_options_id' => 'id']],
            [['products_variants_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsVariants::className(), 'targetAttribute' => ['products_variants_id' => 'id']],
        ];
    }

    public function getProductsOptions()
    {
        return $this->hasOne(ProductsOptions::className(), ['id' => 'products_options_id']);
    }

    public function getProductsVariants()
    {
        return $this->hasOne(ProductsVariants::className(), ['id' => 'products_variants_id']);
    }
}
