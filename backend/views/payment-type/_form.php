<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\backend\widgets\Translateform;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\PaymentType */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary payment-type-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="box-body">

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <?= Translateform::widget(['form'=>$form,'model'=>$model,'attr'=>'name','field'=>'name','formtype'=>'string']); ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

     <?= Translateform::widget(['form'=>$form,'model'=>$model,'attr'=>'label','field'=>'description','formtype'=>'text']); ?>
	</div>
	<div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
 </div>
    <?php ActiveForm::end(); ?>

</div>
