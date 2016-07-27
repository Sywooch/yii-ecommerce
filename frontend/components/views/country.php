<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Country;

/* @var $this yii\web\View */
/* @var $cssClass string */

$url = Url::to(['country/change']);

$confirm = false;
$countryData = null;

// If session has not valid country, get geo info and suggest confirm it to user
if (!Yii::$app->session->get('country')) {
    $geoInfo = Yii::$app->geolocation->getInfo();
    if (is_array($geoInfo) && array_key_exists('countryCode', $geoInfo)) {
        if ($country = Country::find()->where(['abbr' => $geoInfo['countryCode']])->asArray()->one()) {
            $countryData = $country;
            $confirm = true;
        }
    }
}


$this->registerJs('
    var confirm = ' . ($confirm ? 'true' : 'false') . ';
    var countryData = ' . json_encode($countryData) . ';

    var $selectCountry = $("#select-country");
    var $selectCountryConfirm = $("#select-country-confirm");
    var $selectCountryConfirmModalBody = $selectCountryConfirm.find(".modal-body");
    var $selectCountryConfirmAccept = $selectCountryConfirm.find(".accept");
    var $selectCountryConfirmCancel = $selectCountryConfirm.find(".cancel");

    $selectCountryConfirmModalBody.html("");

    $selectCountry.change(function() {
        $.post("' . $url . '", {country: $(this).val()}, function() {
            location.href = location.href;
        });
    });

    $selectCountryConfirmAccept.click(function() {
        $selectCountryConfirm.modal("hide");
        $selectCountry.val(countryData.id).trigger("change");
    });

    $selectCountryConfirmCancel.click(function() {
        $selectCountryConfirm.modal("hide");
        $selectCountry.click();
    });

    if (confirm && countryData) {
        $selectCountryConfirmModalBody.html("Your country: <strong>" + countryData.name + "</strong>");
        $selectCountryConfirm.modal("show");
    }
');

?>

<?= Html::dropDownList('country', Yii::$app->session->get('country'), ArrayHelper::map(
        Country::find()->orderBy(['name' => 'asc'])->all(),
        'id',
        'name'
    ),
    [
        'prompt' => 'Choose country',
        'class' => $cssClass,
        'id' => 'select-country',
    ]
) ?>

<div id="select-country-confirm" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirm country</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success accept">Yes</button>
                <button type="button" class="btn btn-danger cancel">No</button>
            </div>
        </div>
    </div>
</div>

