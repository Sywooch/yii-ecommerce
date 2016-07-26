<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Unit;
use webdoka\yiiecommerce\common\models\Discount;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $priceDataProvider \yii\data\ArrayDataProvider */

use \yii\helpers\Url;

$pjaxUrl = Url::to([$action]);

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
');

?>

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
