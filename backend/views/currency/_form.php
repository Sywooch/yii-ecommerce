<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
<div class="currency-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'abbr')->textInput(['maxlength' => true]) ?>
        </div> 
    </div>
    <div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
   </div>
    <?php ActiveForm::end(); ?>

</div>
