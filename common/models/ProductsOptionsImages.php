<?php
namespace webdoka\yiiecommerce\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use webdoka\yiiecommerce\common\components\Thumb;

class ProductsOptionsImages extends ActiveRecord
{
    public $imageFiles;

    public static function tableName()
    {
        return '{{%products_options_images}}';
    }

    public function rules()
    {
        return [
            [['product_options_id', 'product_id'], 'required'],
            [['product_options_id', 'product_id'], 'integer'],
            [['image'], 'string'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['product_options_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsOptions::className(), 'targetAttribute' => ['product_options_id' => 'id']],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'product_options_id' => Yii::t('shop', 'Product Options ID'),
            'price_id' => Yii::t('shop', 'Product ID'),
            'image' => Yii::t('shop', 'Image'),
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductOptions()
    {
        return $this->hasOne(ProductsOptions::className(), ['id' => 'product_options_id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $filename = md5($file->baseName . time());
                $image = $filename . '.' . $file->extension;

                $data[] = [
                    $this->product_id,
                    $this->product_options_id,
                    $image,
                ];

                $path = Yii::getAlias('@webroot') . '/uploads/product-options-images/' . $image;
                $file->saveAs($path);
            }
            Yii::$app->db->createCommand()
                ->batchInsert($this::tableName(), [
                    'product_id',
                    'product_options_id',
                    'image'
                ], $data)
                ->execute();
            return true;
        } else {
            return false;
        }
    }

    public function getFullSize()
    {
        return Url::to('/uploads/product-options-images/'. $this->image);
    }

    public function getThumb($width, $height)
    {
        return Thumb::getImageAsBase64(
            '@webroot/uploads/product-options-images',
            $this->image,
            $width,
            $height
        );
    }
}
