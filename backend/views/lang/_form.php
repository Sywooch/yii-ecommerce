<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary lang-form">
    <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'local')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'default')->dropDownList(['0' => Yii::t('shop', 'No'),'1' => Yii::t('shop', 'Yes')]); ?>

            <?php if ($model->isNewRecord) {

                        echo $form->field($model, 'date_create')->hiddenInput(['value'=>date('U')])->label(false);
                    }else{

                        echo $form->field($model, 'date_create')->hiddenInput()->label(false);

                    }
            ?>
            
         <?= $form->field($model, 'date_update')->hiddenInput(['value'=>date('U')])->label(false) ?>

        </div> 
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
