<?php

namespace webdoka\yiiecommerce\common\models;

use creocoder\nestedsets\NestedSetsBehavior;
use webdoka\yiiecommerce\common\queries\ProductsOptionsQuery;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "products_options".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $description
 * @property string $image
 * @property integer $status
 * @property string $icon
 * @property integer $icon_type
 * @property integer $active
 * @property integer $selected
 * @property integer $disabled
 * @property integer $readonly
 * @property integer $visible
 * @property integer $collapsed
 * @property integer $movable_u
 * @property integer $movable_d
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 * @property integer $root
 * @property integer $lvl
 *
 * @property ProductsOptionsPrices[] $productsOptionsPrices
 */
class ProductsOptions extends \yii\db\ActiveRecord
{

    const LIST_POPTIONS = 'shopListOptionsProducts';
    const VIEW_POPTIONS = 'shopViewOptionsProducts';
    const CREATE_POPTIONS = 'shopCreateOptionsProducts';
    const UPDATE_POPTIONS = 'shopUpdateOptionsProducts';
    const DELETE_POPTIONS = 'shopDeleteOptionsProducts';

    use \kartik\tree\models\TreeTrait {
        isDisabled as parentIsDisabled; // note the alias
    }

    /**
     * @var string product id`s. String from hidden field tree form
     */
    public $products_id;

    /**
     * @var string the classname for the TreeQuery that implements the NestedSetQueryBehavior.
     * If not set this will default to `kartik  ree\models\TreeQuery`.
     */
    public static $treeQueryClass; // change if you need to set your own TreeQuery

    /**
     * @var bool whether to HTML encode the tree node names. Defaults to `true`.
     */
    public $encodeNodeNames = true;

    /**
     * @var bool whether to HTML purify the tree node icon content before saving.
     * Defaults to `true`.
     */
    public $purifyNodeIcons = true;

    /**
     * @var array activation errors for the node
     */
    public $nodeActivationErrors = [];

    /**
     * @var array node removal errors
     */
    public $nodeRemovalErrors = [];

    /**
     * @var bool attribute to cache the `active` state before a model update. Defaults to `true`.
     */
    public $activeOrig = true;
    public $imagef;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['tree', 'lft', 'rgt', 'depth', 'name', 'lvl'], 'required'],
            [['tree', 'lft', 'rgt', 'depth', 'status', 'icon_type', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'root', 'lvl'], 'integer'],
            [['description'], 'string'],
            [['name', 'icon'], 'string', 'max' => 255],
            [['imagef'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'tree' => Yii::t('shop', 'Tree'),
            'lft' => Yii::t('shop', 'Lft'),
            'rgt' => Yii::t('shop', 'Rgt'),
            'depth' => Yii::t('shop', 'Depth'),
            'name' => Yii::t('shop', 'Name'),
            'description' => Yii::t('shop', 'Description'),
            'image' => Yii::t('shop', 'Image'),
            'status' => Yii::t('shop', 'Status'),
            'icon' => Yii::t('shop', 'Icon'),
            'icon_type' => Yii::t('shop', 'Icon Type'),
            'active' => Yii::t('shop', 'Active'),
            'selected' => Yii::t('shop', 'Selected'),
            'disabled' => Yii::t('shop', 'Disabled'),
            'readonly' => Yii::t('shop', 'Readonly'),
            'visible' => Yii::t('shop', 'Visible'),
            'collapsed' => Yii::t('shop', 'Collapsed'),
            'movable_u' => Yii::t('shop', 'Movable U'),
            'movable_d' => Yii::t('shop', 'Movable D'),
            'movable_l' => Yii::t('shop', 'Movable L'),
            'movable_r' => Yii::t('shop', 'Movable R'),
            'removable' => Yii::t('shop', 'Removable'),
            'removable_all' => Yii::t('shop', 'Removable All'),
            'root' => Yii::t('shop', 'Root'),
            'lvl' => Yii::t('shop', 'Lvl'),
        ];
    }

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'root',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'lvl',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsOptionsPrices()
    {
        return $this->hasMany(ProductsOptionsPrices::className(), ['product_options_id' => 'id'])->where(ProductsOptionsPrices::tableName().'.status = 1');
    }

    public function isDisabled()
    {
        if (
            Yii::$app->user->can(self::CREATE_POPTIONS) &&
            Yii::$app->user->can(self::UPDATE_POPTIONS) &&
            Yii::$app->user->can(self::DELETE_POPTIONS) &&
            Yii::$app->user->can(Product::CREATE_PRODUCT) &&
            Yii::$app->user->can(Product::UPDATE_PRODUCT) &&
            Yii::$app->user->can(Product::DELETE_PRODUCT)
        ) {
            return $this->parentIsDisabled();
        }
        return true;
    }

    public static function isAdminTree()
    {
        if (
            Yii::$app->user->can(self::CREATE_POPTIONS) &&
            Yii::$app->user->can(self::UPDATE_POPTIONS) &&
            Yii::$app->user->can(self::DELETE_POPTIONS) &&
            Yii::$app->user->can(Product::CREATE_PRODUCT) &&
            Yii::$app->user->can(Product::UPDATE_PRODUCT) &&
            Yii::$app->user->can(Product::DELETE_PRODUCT)
        ) {
            return true;
        }
        return false;
    }

    public function upload()
    {

        if ($this->validate()) {

            $path = Yii::getAlias('@webroot') . '/uploads/po/' . $this->imagef->baseName . '.' . $this->imagef->extension;
            $this->imagef->saveAs($path);

            return $path;
        } else {
            var_dump($this->getErrors());
            exit;
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function CheckedTree($id)
    {

        $curroptions = ProductsOptionsPrices::find()->where(['=', "product_id", $id])->andWhere(['=', "status", 1])->groupBy(['product_options_id'])->all();

        $chk = [];

        $chek = '';

        if ($curroptions != null) {

            foreach ($curroptions as $chknode) {
                $chk[] = $chknode->product_options_id;
            }

            return implode(',', $chk);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function isOption($id)
    {

        $getchild = ProductsOptions::findOne($id);

        if ($getchild != false) {

            return $getchild->children()->all();
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricesWithValues($id, $prid = null)
    {
        $data = [];

        $prices = Price::find()->all();
        foreach ($prices as $price) {
            $productPrice = ProductsOptionsPrices::find()->where([
                'product_options_id' => $id,
                'price_id' => $price->id,
                'product_id' => $prid,
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
     * @inheritdoc
     * @return ProductsOptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsOptionsQuery(get_called_class());
    }

}
