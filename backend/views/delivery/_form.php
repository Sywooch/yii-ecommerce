<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\forms\StorageForm;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use \yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\components\PostApi;
use kartik\select2\Select2;
use webdoka\yiiecommerce\common\models\DeliveriDiscount;

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
<div class="delivery-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4><?= Yii::t('shop', 'Delivery info') ?></h4>
        </div>
        <div class="box-body">


            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'cost')->textInput() ?>

            <?= $form->field($model, 'type')->dropDownList($model->typeLists) ?>


        </div>

    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h4><?= Yii::t('shop', 'Delivery from') ?></h4>
        </div>
        <div class="box-body">
            <div class="delivery-form">

                <?php Pjax::begin(['id' => 'storage']) ?>

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
                $form->field($model, 'storage_id')->dropDownList(
                    ArrayHelper::merge(['' => 'Select storage'], StorageForm::getStoragesByCountryAndCity($model->country, $model->city))
                )->label(Yii::t('shop', 'Storage'))
                ?>

                <?php Pjax::end() ?>

            </div>
        </div>

    </div>


    <div class="box box-primary">
        <div class="box-header with-border">
            <h4><?= Yii::t('shop', 'Delivery to') ?></h4>
        </div>
        <div class="box-body">
            <div class="delivery-form">
                <?=
                $form->field($model, 'pak_id')->dropDownList(ArrayHelper::merge(['' => 'Select pak'], ArrayHelper::map(DeliveriesLocationsPak::find()->all(), 'id', 'name'))
                )
                ?>

            </div>
        </div>

    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h4><?= Yii::t('shop', 'Discount') ?></h4>
        </div>
        <div class="box-body">

            <?= $form->field($model, 'relDiscounts')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DeliveriDiscount::find()->orderBy(['name' => 'asc'])->all(), 'id', 'name'),
                'options' => [
                    //'placeholder' => 'Select provinces ...',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>


    </div>

    <?php ActiveForm::end(); ?>
</div>  