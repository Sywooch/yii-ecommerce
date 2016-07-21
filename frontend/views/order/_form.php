<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Property;
use webdoka\yiiecommerce\common\models\PaymentType;

/* @var $this yii\web\View */
/* @var $model \yii\base\DynamicModel */
/* @var $orderModel webdoka\yiiecommerce\common\models\Order */
/* @var $properties webdoka\yiiecommerce\common\models\Property $properties[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php foreach ($model->getAttributes() as $attribute => $value) { ?>

        <?php if ($properties[$attribute]->type == 'input') { ?>

            <?= $form->field($model, $attribute)->textInput()->label($properties[$attribute]->label) ?>

        <?php } elseif ($properties[$attribute]->type == 'checkbox') { ?>

            <?= $form->field($model, $attribute)->checkbox(['label' => $properties[$attribute]->label]) ?>

        <?php } elseif ($properties[$attribute]->type == 'textarea') { ?>

            <?= $form->field($model, $attribute)->textarea()->label($properties[$attribute]->label) ?>

        <?php } ?>

    <?php } ?>

    <hr>

    <?= $form->field($orderModel, 'payment_type_id')->dropDownList(PaymentType::find()->indexBy('id')->select('name')->column()) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
