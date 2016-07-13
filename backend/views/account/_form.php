<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Currency;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'balance')->textInput() ?>

    <?= $form->field($model, 'currency_id')->dropDownList(Currency::find()->select('symbol')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'user_id')->dropDownList(User::find()->select('username')->indexBy('id')->column()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
