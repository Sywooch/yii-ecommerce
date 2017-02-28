<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'exists_tax')->checkbox() ?>

    <?= $form->field($model, 'tax')->textInput() ?>
        </div> 
    </div>
    <div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
   </div>
    <?php ActiveForm::end(); ?>

</div>
