<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Discount;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\forms\SetForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $products array */

$this->registerJs('
    var $page = $(".set-form")
    var $form = $("#setForm");
    var $addProduct = $form.find(".add-product");
    var $setProducts = $form.find(".set-products");
    var $productTemplate = $page.find(".product-template");

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
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id' => 'setForm']); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <h2><?= Yii::t('shop', 'Discounts') ?></h2>

        <?= $form->field($model, 'relDiscounts')->dropDownList(ArrayHelper::map(Discount::find()->set()->all(), 'id', 'name'), ['multiple' => true]) ?>

        <h2><?= Yii::t('shop', 'Products') ?> <span class="add-product btn btn-success pull-right"><?= Yii::t('shop', 'Add Product') ?></span></h2>

        <?php if (Yii::$app->session->hasFlash('set-error')) { ?>
            <div class="alert alert-danger"><?= Html::encode(Yii::$app->session->getFlash('set-error')) ?></div>
        <?php } ?>

        <div class="well set-products">
            <?php foreach ($model->relSetsProducts as $index => $setProduct) { ?>

                <div class="row set-product">

                    <div class="col-md-8">
                        <?=
                                $form->field($model, 'relSetsProducts[' . $index . '][product_id]')
                                ->dropDownList(ArrayHelper::map($products, 'id', 'name'))
                                ->label(false);
                        ?>
                    </div>

                    <div class="col-md-2">
                        <?=
                                $form->field($model, 'relSetsProducts[' . $index . '][quantity]')
                                ->textInput(['placeholder' => Yii::t('shop', 'Quantity')])->label(false)
                        ?>
                    </div>

                    <div class="col-md-2">
                        <div class="delete-product btn btn-danger btn-block"><?= Yii::t('yii', 'Delete') ?></div>
                    </div>

                </div>

<?php } ?>

        </div>

<?php ActiveForm::end(); ?>

        <div class="product-template hide">

            <div class="row set-product">

                <div class="col-md-8">
                    <?=
                            $form->field($model, 'relSetsProducts[%set_product_id%][product_id]')
                            ->dropDownList(ArrayHelper::map($products, 'id', 'name'))
                            ->label(false);
                    ?>
                </div>

                <div class="col-md-2">
                    <?=
                            $form->field($model, 'relSetsProducts[%set_product_id%][quantity]')
                            ->textInput(['placeholder' => Yii::t('shop', 'Quantity')])->label(false)
                    ?>
                </div>

                <div class="col-md-2">
                    <div class="delete-product btn btn-danger btn-block"><?= Yii::t('yii', 'Delete') ?></div>
                </div>
            </div>

        </div>

    </div>
</div>
