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

if (!$model->isNewRecord) {

    $this->registerJs('

        var tabpage=sessionStorage["tabPage"];

        $(".nav-tabs a[href=\""+tabpage+"\"]").tab("show");

        ');
} else {
    $this->registerJs('

    $(document).on("click",".nav-tabs a[href=\"#options\"]", function(event, key) {
        alert("' . Yii::t('shop', 'Create prduct first!') . '");
        return false;
        });

        ');
}

$this->registerJs('
    $(function(){
        $("[data-toggle=popover]").popover({
            html : true,
            content: function() {
              var content = $(this).attr("data-popover-content");
              return $(content).children(".popover-body").html();
          },
          title: function() {
              var title = $(this).attr("data-popover-content");
              return $(title).children(".popover-heading").html();
          }
      });
  });    
  ');

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

<div class="box box-primary">
    <div class="box-header with-border">

        <ul class="nav nav-tabs">

            <li role="presentation" class="active"><a href="#products" aria-controls="products" role="tab"
                                                      data-toggle="tab"><?= Yii::t('shop', 'Product') ?></a></li>

            <li role="presentation"><a href="#characteristics" aria-controls="characteristics" role="tab"
                                       data-toggle="tab"><?= Yii::t('shop', 'Сharacteristics') ?></a></li>

            <li role="presentation"><a href="#prices" aria-controls="prices" role="tab"
                                       data-toggle="tab"><?= Yii::t('shop', 'Prices') ?></a></li>

            <li class="<?= ($model->isNewRecord) ? ('disabled') : (''); ?>" role="presentation"><a href="#options"
                                                                                                   aria-controls="options"
                                                                                                   role="tab" <?= (!$model->isNewRecord) ? ('data-toggle="tab"') : (''); ?> ><?= Yii::t('shop', 'Product Options') ?></a>
            </li>


        </ul>
    </div>
    <div class="box-body">
        <div class="tab-content" role="tablist">

            <div role="tabpanel" class="tab-pane fade in active" id="products">


                <div class="product-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= Html::hiddenInput('action', $model->isNewRecord ? 'create' : 'update') ?>

                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name'), ['class' => 'form-control']) ?>


                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                </div>

            </div>


            <div role="tabpanel" class="tab-pane fade in" id="characteristics">


                <?= $form->field($model, 'unit_id')->dropDownList(ArrayHelper::map(Unit::find()->all(), 'id', 'name'), ['class' => 'form-control']) ?>


                <label><?= Yii::t('shop', 'Features') ?></label>

                <div class="well">
                    <?php Pjax::begin(['id' => 'features']) ?>

                    <?=
                    ListView::widget([
                        'itemView' => '_feature',
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                    ]);
                    ?>

                    <?php Pjax::end() ?>
                </div>


                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            </div>


            <div role="tabpanel" class="tab-pane fade in" id="prices">

                <label><?= Yii::t('shop', 'Prices') ?></label>

                <div class="well">
                    <?= $form->field($model, 'price', [
                        'template' => "<div class='form-group'>
                        <div class='row'>
                            <div class='col-xs-2'>{label} </div>
                            <div class='col-xs-10'>{input}\n{hint}\n{error}
                            </div>
                        </div>
                    </div>"
                    ])->textInput() ?>
                    <?=
                    ListView::widget([
                        'itemView' => '_price',
                        'dataProvider' => $priceDataProvider,
                        'summary' => false,
                    ]);
                    ?>
                </div>

                <?= $form->field($model, 'relDiscounts')->dropDownList(ArrayHelper::map(Discount::find()->all(), 'id', 'name'), ['multiple' => true]) ?>


                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>


            <div role="tabpanel" class="tab-pane fade" id="options">

                <div class="product-form">
                    <a style="float:right; cursor:pointer;" id="element" data-container="body"
                       data-toggle="popover"
                       data-placement="bottom" data-popover-content="#taboptions">
                        <span class="glyphicon glyphicon-question-sign"></span>
                    </a>

                    <?=
                    TreeView::widget([
                        'query' => ProductsOptions::find()->addOrderBy('root, lft')->active(),
                        'id' => 'products_options_product',
                        'options' => ['id' => 'products_options_product', 'enctype' => 'multipart/form-data'],
                        'nodeFormOptions' => ['enctype' => 'multipart/form-data'],
                        'showCheckbox' => true,
                        'multiple' => true,
                        'value' => ProductsOptions::CheckedTree($model->id),
                        'showIDAttribute' => false,
                        'nodeView' => '@vendor/webdoka/yii-ecommerce/backend/views/products-options/_formtree',
                        'nodeAddlViews' => [
                            Module::VIEW_PART_2 => '@vendor/webdoka/yii-ecommerce/backend/views/products-options/_formnode'
                        ],
                        'nodeActions' => [
                            Module::NODE_MANAGE => Url::to(['/treemanager/node/manage', 'id' => $model->id]),
                            Module::NODE_SAVE => Url::to(['/admin/shop/products-options/save/', 'pid' => $model->id]),
                            // Module::NODE_REMOVE => Url::to(['/treemanager/node/remove']),
                            // Module::NODE_MOVE => Url::to(['/treemanager/node/move']),
                        ],
                        //'headingOptions' => ['label' => Yii::t('shop', 'Product Options')],
                        'fontAwesome' => false, // optional
                        // 'isAdmin' => ProductsOptions::isAdminTree(), // optional (toggle to enable admin mode)
                        'isAdmin' => false,
                        'displayValue' => 1, // initial display value
                        'softDelete' => false, // defaults to true
                        'cacheSettings' => [
                            'enableCache' => false   // defaults to true
                        ],
                    ]);
                    ?>

                </div>

            </div>

        </div>
    </div>

</div>


<div class="hidden col-xs-12" id="taboptions">
    <div class="popover-heading">
        Как это работает?
    </div>

    <div class="popover-body">

        Каждая рут категория создаёт кнопку которая открывает Popover с вложенной в эту категорию веткой свойств.
        В каждой вложенной ветке свойств можно выбрать одно свойство которое изменит цену на значение выставленное в
        разделе "Товары" >> Выбрать товар для редактирования >> вкладка "Свойства товара" >> нажать на свойство "Цены".
        Если выставленное значение должно уменьшать базовую цену, тогда значение должно быть отрицательным числом.
    </div>
</div>