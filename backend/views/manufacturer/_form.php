<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="manufacturer-form">

    <?php $form = ActiveForm::begin(['id' => 'manufacturer']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    <?php ActiveForm::end(); ?>
    <?= $form->field($model, 'logo')->widget('\webdoka\filestorage\widgets\Upload',[
        'formId' => 'manufacturer'
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'form'=>'manufacturer'
        ]) ?>
    </div>
</div>
