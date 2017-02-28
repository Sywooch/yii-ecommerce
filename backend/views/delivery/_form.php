<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\forms\StorageForm;
use \yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Delivery */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */

$this->registerJs('
    $(function () {

        var $delivery = ".delivery-form",
            $country = "#deliveryform-country",
            $city = "#deliveryform-city";

        $($delivery).on("change", $country + ", " + $city, function () {
            $.pjax.reload({
                url: "' . $url . '",
                data: {
                    country: $($country).val(),
                    city: $($city).val()
                },
                container: "#storage",
            });
        });
    });
');
?>
<div class="box box-primary">
    <div class="box-body">
<div class="delivery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?php Pjax::begin(['id' => 'storage']) ?>

        <?= $form->field($model, 'country')->dropDownList(
            ArrayHelper::merge(['' => 'Select country'], StorageForm::getCountries())
        ) ?>

        <?= $form->field($model, 'city')->dropDownList(
            ArrayHelper::merge(['' => 'Select city'], StorageForm::getCitiesByCountry($model->country))
        ) ?>

        <?= $form->field($model, 'storage_id')->dropDownList(
            ArrayHelper::merge(['' => 'Select storage'], StorageForm::getStoragesByCountryAndCity($model->country, $model->city))
        )->label(Yii::t('shop', 'Storage')) ?>

    <?php Pjax::end() ?>
        </div> 
    </div>
    <div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
   </div>
    <?php ActiveForm::end(); ?>

</div>
