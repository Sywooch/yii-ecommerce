<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Category;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?php Pjax::begin(['id' => 'features']) ?>

    <h2>Features</h2>

    <?= ListView::widget([
        'itemView' => '_feature',
        'dataProvider' => $dataProvider,
        'summary' => false,
    ]); ?>

    <?php Pjax::end() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
