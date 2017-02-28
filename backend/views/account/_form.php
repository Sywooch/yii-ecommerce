<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Currency;
use webdoka\yiiecommerce\common\forms\TransactionForm;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'balance')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'currency_id')->dropDownList(Currency::find()->select('symbol')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(TransactionForm::getUsers(), 'profile.id', 'username')) ?>
        </div> 
    </div>
    <div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
   </div>
    <?php ActiveForm::end(); ?>

</div>
