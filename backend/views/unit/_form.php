<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\backend\widgets\Translateform;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary unit-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= Translateform::widget(['form'=>$form,'model'=>$model,'attr'=>'name']); ?>

</div>
<div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

</div>
