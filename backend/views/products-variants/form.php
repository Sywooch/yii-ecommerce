<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\ProductsVariants;
?>

<div class="products-variants-form">

    <?php $form = ActiveForm::begin([
        'id' => 'variants-form',
        'enableAjaxValidation' => true,
        //'action' => Url::toRoute('user/ajaxregistration'),
        // 'validationUrl' => Url::toRoute('user/ajaxregistration')
    ]); ?>


    <?= $form->field($model, 'quantity_stock')->textInput(['type' => 'number', 'min'=>0]) ?>
    <?php foreach (ProductsVariants::getOptions($model->product_id) as $key => $value): ?>
        <?= $form->field($model, "values[$key]")->dropDownList(ProductsVariants::getVariants($key), ['prompt' => Yii::t('shop','Select')])->label($value['label']) ?>
    <?php endforeach; ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_code', [
        'template' => '{label}<div class="input-group"><div class="input-group-addon">'.$model->product->vendor_code.'.</div>{input}</div>{hint}{error}'
        ])->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
