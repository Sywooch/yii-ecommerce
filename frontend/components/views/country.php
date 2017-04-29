<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Country;

//use Yii;
/* @var $this yii\web\View */
/* @var $cssClass string */

$url = Url::to(['country/change']);

$confirm = false;
$countryData = null;

mb_internal_encoding("8bit");
    $geo = new \jisoft\sypexgeo\Sypexgeo();
    
    $geo->get(); 
   // $geo->get('213.111.167.152');

    //var_dump($geo->country); echo '<br>';


// If session has not valid country, get geo info and suggest confirm it to user
if (Yii::$app->request->cookies->getValue('country') ===null){
//if (!Yii::$app->session->get('country')) {
    $geoInfo = $geo->country;
    if (is_array($geoInfo) && array_key_exists('name_ru', $geoInfo)) {
        if ($country = Country::find()->where('name LIKE "%' . $geoInfo['name_ru'] . '%"')->asArray()->one()) {
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

    $("#select-country-confirm").on("shown.bs.modal", function () {
    var width = $(window).width();  
    if(width < 480){
        console.log(width);
        $(this).modal("hide"); 
    }
});
');
?>

<?= Html::dropDownList('country', Yii::$app->request->cookies->getValue('country'), ArrayHelper::map(
    Country::find()->orderBy(['name' => 'asc'])->all(), 'id', 'name'
), [
        'prompt' => Yii::t('shop', 'Choose country'),
        'class' => $cssClass,
        'id' => 'select-country',
    ]
)

?>

<div id="select-country-confirm" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?= Yii::t('shop', 'Confirm country') ?></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success accept"><?= Yii::t('shop', 'Yes') ?></button>
                <button type="button" class="btn btn-danger cancel"><?= Yii::t('shop', 'No') ?></button>
            </div>
        </div>
    </div>
</div>
