<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\field\FieldRange;
use kartik\form\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\Discount;
use kartik\select2\Select2;

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
<?php /*
            <?=
            $form->field($model, 'started_at')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => ['dateFormat' => 'yyyy-MM-dd'],
                'options' => ['class' => 'form-control']
            ])
            ?>

            <?=
            $form->field($model, 'finished_at')->widget(DatePicker::className(), [
                'dateFormat' => 'php:Y-m-d',
                'options' => ['class' => 'form-control']
            ])
         ?>
*/

         ?>
         <?= FieldRange::widget([
            'form' => $form,
            'model' => $model,
            'label' => Yii::t('shop', 'Enter date range'),
            'attribute1' => 'started_at',
            'attribute2' => 'finished_at',
            'type' => FieldRange::INPUT_DATETIME,
            'widgetClass' => DateControl::classname(),
            'widgetOptions1' => [
        //'saveFormat' => 'php:Y-m-d',
            'options'=>[
            'pluginOptions' => ['autoclose' => true,],
            ],                
            ],
            'widgetOptions2' => [
       // 'saveFormat' => 'php:Y-m-d',
            'options'=>[
            'pluginOptions' => ['autoclose' => true,],
            ],                
            ],
            ]);
            ?>

            <?= $form->field($model, 'count')->textInput() ?>

            <h2><?php /* Yii::t('shop', 'Apply to products') */ ?></h2>

            <?php /*
            $form->field($model, 'relProducts')->dropDownList(
                ArrayHelper::map(Product::find()->all(), 'id', 'name', 'category.name'), ['multiple' => true, 'size' => 10]
                )->label(false) */
                ?>
<?php /*
$form->field($model, 'relProducts')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name', 'category.name'),
    'options' => [
        //'placeholder' => 'Select provinces ...',
        'multiple' => true
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
    ]);*/ ?>


</div>
</div>
<div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

</div>
