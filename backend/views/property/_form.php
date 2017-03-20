<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Property;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary property-form">
    <div class="box-body">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type')->dropDownList(Property::getTypes()) ?>

        <?= $form->field($model, 'profile_type')->dropDownList(Property::getProfileTypes()) ?>

        <?= $form->field($model, 'required')->checkbox() ?>

    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
