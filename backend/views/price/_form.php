<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AuthItem;
/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary price-form">

            <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">

            <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'auth_item_name')->dropDownList(
                AuthItem::find()->rolesOnly()->available()
                ->indexBy('name')
                ->select('name')->column(),
                ['prompt' => 'Choose role']
                ) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
