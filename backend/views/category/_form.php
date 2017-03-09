<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Feature;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="category-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'parent_id')->textInput() ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?=
            $form->field($model, 'relFeatures')->dropDownList(
                    ArrayHelper::map(Feature::find()->orderBy(['name' => 'asc'])->all(), 'id', 'name'), [
                'class' => 'form-control',
                'multiple' => true,
            ])
            ?>
        </div> 
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

