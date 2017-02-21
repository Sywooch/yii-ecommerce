<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="lang-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'local')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'default')->textInput() ?>

            <?= $form->field($model, 'date_update')->textInput() ?>

            <?= $form->field($model, 'date_create')->textInput() ?>
        </div> 
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
