<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\Discount;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Discount */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="discount-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'dimension')->dropDownList(Discount::getDimensions()) ?>

            <?= $form->field($model, 'value')->textInput() ?>

            <?= $form->field($model, 'started_at')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
                ]) ?>

            <?= $form->field($model, 'finished_at')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
                ]) ?>

                <?= $form->field($model, 'count')->textInput() ?>

                <h2><?=Yii::t('shop', 'Apply to products') ?></h2>

                <?= $form->field($model, 'relProducts')->dropDownList(
                    ArrayHelper::map(Product::find()->all(), 'id', 'name', 'category.name'),
                    ['multiple' => true, 'size' => 10]
                    )->label(false) ?>
                </div> 
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
