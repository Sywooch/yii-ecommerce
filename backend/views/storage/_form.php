<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\forms\StorageForm;
use \yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Storage */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */

$this->registerJs('
    $(function () {

        var $storage = ".storage-form",
            $country = "#storageform-country",
            $city = "#storageform-city",
            $address = "#storageform-address",
            $locationId = "#storageform-location_id";

        $($storage).on("change", $country + ", " + $city, function () {
            $.pjax.reload({
                url: "' . $url . '",
                data: {
                    country: $($country).val(),
                    city: $($city).val()
                },
                container: "#location",
            });
        });

        $($storage).on("change", $address, function () {
            var locationId = $($address).val();
            $($locationId).val(locationId ? locationId : "");
        });
    });
');
?>

<div class="box box-primary storage-form">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php Pjax::begin(['id' => 'location']) ?>

        <?=
        $form->field($model, 'country')->dropDownList(
                ArrayHelper::merge(['' => 'Select country'], StorageForm::getCountries())
        )
        ?>

        <?=
        $form->field($model, 'city')->dropDownList(
                ArrayHelper::merge(['' => 'Select city'], StorageForm::getCitiesByCountry($model->country))
        )
        ?>

        <?=
        $form->field($model, 'address')->dropDownList(
                ArrayHelper::merge(['' => 'Verify address'], StorageForm::getAddressByCountryAndCity($model->country, $model->city))
        )
        ?>

        <?= $form->field($model, 'location_id')->hiddenInput()->label(false)->error(false) ?>

        <?php Pjax::end() ?>

        <?= $form->field($model, 'schedule')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'phones')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'iconImage')->fileInput(['accept' => 'image/*']) ?>

        <?php if ($model->icon) { ?>
            <?= Html::img($model->iconUrl, ['width' => 80, 'height' => 80, 'class' => 'thumbnail']) ?>
        <?php } ?>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
