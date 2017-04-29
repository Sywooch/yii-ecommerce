<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Property;
use webdoka\yiiecommerce\common\models\PaymentType;
use webdoka\yiiecommerce\common\models\Storage;
use webdoka\yiiecommerce\common\components\PostApi;

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
    <?php

    $storages = Storage::find()->all();

    foreach ($storages as $value) :?>
<div class="cart-table table-responsive">
    <h4>Склад: <?= $value->name ?></h4>
    <table class="table text-center">
    <thead>


    </thead>
    <tbody>
        <?php foreach ($value->deliveries as $delivery) : ?>
            <tr>
                <td>
                    <?= $delivery->name ?>
                </td>
                <td>
                    <?= Yii::$app->formatter->asCurrency($delivery->cost) ?>
                </td>
                <td>
                    <?= $delivery->getTypeLists()[$delivery->type] ?>
                </td>
            </tr>
        <?php endforeach;?>
       </tbody>
    </table>
</div>
<?php endforeach;?>

    <?= $form->field($orderModel, 'payment_type_id')->dropDownList(PaymentType::find()->indexBy('id')->select('label')->column()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
