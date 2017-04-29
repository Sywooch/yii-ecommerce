<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Feature;
use webdoka\yiiecommerce\common\models\Category;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Category */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('
    $(document).on("click","a[role=\"tab\"]", function(event, key) {

     sessionStorage["tabPage"] = $(this).attr("href");

 }); 
 ');

    $this->registerJs('

        var tabpage=sessionStorage["tabPage"];

        $(".nav-tabs a[href=\""+tabpage+"\"]").tab("show");

        ');


$this->registerJs('
    var $page = $(".set-form")
    var $form = $("#setForm");
    var $addProduct = $form.find(".add-product");
    var $setProducts = $form.find(".set-products");
    var $productTemplate = $page.find(".product-template");
console.log($setProducts);
    $addProduct.click(function () {
        var template = $productTemplate.html();
        var index = $form.find(".set-product").length + 1;
        template = template.replace(/%set_product_id%/g, index);
        $setProducts.append(template);
    });

    $form.on("click", ".delete-product", function () {
        $(this).closest(".set-product").remove();
    });
');
?>

<div class="box box-primary set-form">

  <div class="box-header with-border">
    <ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="#category" aria-controls="category" role="tab"
              data-toggle="tab"><?= Yii::t('shop', 'Category') ?></a></li>

    <li role="presentation"><a href="#characteristics" aria-controls="characteristics" role="tab"
                 data-toggle="tab"><?= Yii::t('shop', 'Сharacteristics') ?></a></li>
                
    </ul>


  </div>

    <div class="box-body">
  <?php $form = ActiveForm::begin(['id' => 'setForm']); ?>
<div class="tab-content" role="tablist">

        <div role="tabpanel" class="tab-pane fade in active" id="category">
        <div class="category-form">

          <?php 

            if ($model->isNewRecord) {

                $parent = Category::find()->all();

            } else {

                $parent = Category::find()->andWhere(['<>', 'id', $model->id])->all();
            }

            ?>

            <?=
            $form->field($model, 'parent_id')->dropDownList(
                ArrayHelper::map($parent, 'id', 'name'), ['prompt' => Yii::t('shop', 'Choose Category')]
            )
            ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>


        </div>
    </div>

<div role="tabpanel" class="tab-pane fade" id="characteristics">

<?= $form->field($model, 'relFeatures')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Feature::find()->orderBy(['name' => 'asc'])->all(), 'id', 'name'),
    'options' => [
        //'placeholder' => 'Select provinces ...',
        'multiple' => true
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

        <h2> &nbsp; <span class="add-product btn btn-success pull-right"><?= Yii::t('shop_spec', 'Add Feature') ?></span></h2>

        <div class="well set-products">

        </div>


 </div>

  </div> 
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

        <div class="product-template hide">

            <div class="row set-product form-group">
            <?=Html::hiddenInput('Feature[%set_product_id%][id]', 0); ?>
                <div class="col-md-6">

                 <?= Html::input('text', 'Feature[%set_product_id%][name]', '', ['class' => 'form-control','placeholder' => Yii::t('shop', 'Name'),'required'=>true]) ?>
                </div>

                <div class="col-md-4">
                <?= Html::input('text', 'Feature[%set_product_id%][slug]', '', ['class' => 'form-control','placeholder' => Yii::t('shop', 'Slug'),'required'=>true]) ?>

                </div>

                <div class="col-md-2">
                    <div class="delete-product btn btn-danger btn-block"><?= Yii::t('yii', 'Delete') ?></div>
                </div>
            </div>

        </div>

</div>


