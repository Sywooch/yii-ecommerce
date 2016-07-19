<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AuthItem;
/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_item_name')->dropDownList(
        AuthItem::find()->rolesOnly()->available()
            ->indexBy('name')
            ->select('name')->column(),
        ['prompt' => 'Choose role']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
