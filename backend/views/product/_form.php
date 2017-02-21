<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Unit;
use webdoka\yiiecommerce\common\models\Discount;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use kartik\tree\Module;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $priceDataProvider \yii\data\ArrayDataProvider */

use \yii\helpers\Url;

$pjaxUrl = Url::to([$action]);
$ajaxtreeUrl = Url::to(['/admin/shop/products-options/ajax/']);

$this->registerJs('
    $(document).on("click","a[role=\"tab\"]", function(event, key) {

       sessionStorage["tabPage"] = $(this).attr("href");

   }); 
   ');

if(!$model->isNewRecord){

    $this->registerJs('

        var tabpage=sessionStorage["tabPage"];

        $(".nav-tabs a[href=\""+tabpage+"\"]").tab("show");

        ');
}else{
    $this->registerJs('

    $(document).on("click",".nav-tabs a[href=\"#options\"]", function(event, key) {
        alert("Create prduct first!");
        return false;
        });

        ');

}

$this->registerJs('
    $(function () {

        var $category = $("#productform-category_id");

        $category.change(function () {
            $.pjax.reload({
                url: "' . $pjaxUrl . '",
                data: {
                    id: $("#productform-id").val(),
                    category_id: $(this).val(),
                },
                container: "#features",
            });
        });

        $category.trigger("change");
    });


    $(document).on("click",".kv-node-checkbox", function(event, key) {

        var optid=[];

        $(".kv-selected").each(function(data){
         optid.push($( this ).data("key"));
     });


     $.post("' . $ajaxtreeUrl . '", {
        prodid: $("#productform-id").val(),
        optid: optid,
    }, function () {


    });

    $("#productsoptions-products_ids").val(optid);
});

');

?>
<ul class="nav nav-tabs">

    <li role="presentation" class="active"><a href="#products" aria-controls="products" role="tab" data-toggle="tab">Product</a></li>

    <li class="<?= ($model->isNewRecord)?('disabled'):('');?>" role="presentation"><a href="#options" aria-controls="options" role="tab" <?= (!$model->isNewRecord)?('data-toggle="tab"'):('');?> >Options</a></li>


</ul>

<div class="tab-content" role="tablist">

    <div role="tabpanel" class="tab-pane fade in active" id="products">


        <div class="product-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= Html::hiddenInput('action', $model->isNewRecord ? 'create' : 'update') ?>

            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name'), ['class' => 'form-control']) ?>

            <?= $form->field($model, 'unit_id')->dropDownList(ArrayHelper::map(Unit::find()->all(), 'id', 'name'), ['class' => 'form-control']) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'price')->textInput() ?>

            <?= $form->field($model, 'relDiscounts')->dropDownList(ArrayHelper::map(Discount::find()->all(), 'id', 'name'), ['multiple' => true]) ?>

            <h2>Prices</h2>

            <div class="well">
                <?= ListView::widget([
                    'itemView' => '_price',
                    'dataProvider' => $priceDataProvider,
                    'summary' => false,
                    ]); ?>
                </div>

                <h2>Features</h2>

                <div class="well">
                    <?php Pjax::begin(['id' => 'features']) ?>

                    <?= ListView::widget([
                        'itemView' => '_feature',
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                        ]); ?>

                        <?php Pjax::end() ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>  

            <div role="tabpanel" class="tab-pane fade" id="options">

                <div class="product-form">

                    <h2>Options</h2>
                    <?= TreeView::widget([
                    'query' => ProductsOptions::find()->addOrderBy('root, lft')->active(),
                    'id'=>'products_options_product',
                    'options'=>['id'=>'products_options_product','enctype' => 'multipart/form-data'],
                    'nodeFormOptions'=>['enctype' => 'multipart/form-data'],
                    'showCheckbox'=>true,
                    'multiple'=>true,
                    'value'=>ProductsOptions::CheckedTree($model->id),
                    'showIDAttribute' => false,
                    'nodeAddlViews' => [
                    Module::VIEW_PART_2 => '@vendor/webdoka/yii-ecommerce/backend/views/products-options/_formnode'
                    ],
                    'nodeActions' => [
                    Module::NODE_MANAGE => Url::to(['/treemanager/node/manage','id'=>$model->id]),
                    Module::NODE_SAVE => Url::to(['/admin/shop/products-options/save/','pid'=>$model->id]),
                    // Module::NODE_REMOVE => Url::to(['/treemanager/node/remove']),
                    // Module::NODE_MOVE => Url::to(['/treemanager/node/move']),
                    ],
                    'headingOptions' => ['label' => 'Option'],
                    'fontAwesome' => false,     // optional
                    'isAdmin' => ProductsOptions::isAdminTree(),     // optional (toggle to enable admin mode)
                    'displayValue' => 1,        // initial display value
                    'softDelete' => true,       // defaults to true
                    'cacheSettings' => [        
                        'enableCache' => false   // defaults to true
                    ],
                ]);
        ?>

    </div>

</div>

</div>