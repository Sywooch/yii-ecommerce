<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\Cities;
use webdoka\yiiecommerce\common\models\Location;
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Location */
/* @var $form yii\widgets\ActiveForm */

if (!$model->isNewRecord) {
    $cid = Country::getCountryId($model->country);
    if ($cid) {
        if ($model->region != null) {
            $qr = $model->region;
        } else {
            $qr = '';
        }

        if ($model->city != null) {
            $qc = $model->city;
        } else {
            $qc = '';
        }

        $this->registerJs(
            '$.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/formregion') . '",{cid:'.$cid.', type:1, q:"'.$qr.'"},
                            function( data ) {    
                            $( "#regioncontainer" ).html(data);
                            });
            
            $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/formcity') . '",{cid:' . $cid . ',region:"'.$qr.'", type:1, q:"'.$qc.'"},

                            function( data ) {
                                $( "#citycontainer" ).html(data);
                            });


                            '
        );
    }
}


$this->registerJs(
    '$(document).on("click","#new", function(event, key) {
        $("#newpakname").prop("disabled",false);
    }
);
    $(document).on("click","#add", function(event, key) {
        $("#newpakname").prop("disabled");
        $("#newpakname").val("");
    }
);'
);

?>
<div class="box box-primary location-form">

    <div class="box-header with-border">
        <h4><?= Yii::t('shop', 'Paks') ?></h4>

    </div>


    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <div class="row">

            <div class="col-xs-2">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs tabs-left">
                    <li class="active"><a id='add' href="#add-v"
                                          data-toggle="tab"><?= Yii::t('shop', 'Add from exist') ?></a>
                    </li>
                    <li><a id='new' href="#new-v" data-toggle="tab"><?= Yii::t('shop', 'Create new') ?></a></li>
                </ul>
            </div>
            <div class="col-xs-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="add-v">
                        <?php
                        if (isset($pakrelation) && $pakrelation != null) {
                            $opt_id = $pakrelation->pak_id;
                        } else {
                            $opt_id = null;
                        } ?>
                        <?= $form->field($pakmodel, 'name[0]')->dropDownList(ArrayHelper::map($pakmodel::find()->all(), 'id', 'name'), ['class' => 'form-control','options'=>[$opt_id =>["Selected"=>true]]]) ?>
                    </div>
                    <div class="tab-pane" id="new-v">
                        <?= $form->field($pakmodel, 'name[1]')->textInput(['maxlength' => true, 'id' => 'newpakname', 'disabled' => 'disabled']) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="box box-primary location-form">

    <div class="box-header with-border">
        <h4><?= Yii::t('shop', 'Locations') ?></h4>

    </div>

    <div class="box-body">
        <?= $form->field($model, 'type')->hiddenInput(['value' => Location::TYPE_DELIVERY])->label(false); ?>
    <?= $form->field($model, 'country')->hiddenInput(['value' =>  $model->isNewRecord ? ('') : $model->country])->label(false);?> 
    <?= $form->field($model, 'region')->hiddenInput(['value' =>  $model->isNewRecord ? ('') : $model->region])->label(false);?>
    <?= $form->field($model, 'bigcity')->hiddenInput(['value' =>  ''])->label(false);?>  
    <?= $form->field($model, 'city')->hiddenInput(['value' =>  $model->isNewRecord ? ('') : $model->city])->label(false);?> 

        <?php
        echo '<label class="control-label" for="delivery-country">' . Yii::t('shop', 'Country') . '</label>';
        echo Typeahead::widget(
            [
                'id' => 'country',
                'name' => 'country',
                'value' => $model->isNewRecord ? ('') : $model->country,
                'options' => ['placeholder' => 'Filter as countrys ...'],
                'pluginOptions' => ['highlight' => true],
                'pluginEvents' => [
                    "typeahead:select" => 'function( event, ui ) { 

                            $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/formregion') . '",{cid:ui.id, type:2},
                            function( data ) {
                             $( "#location-country" ).val(ui.value);   
                            $( "#regioncontainer" ).html(data);
                            });

                            }',
                ],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => Url::to(['country/country-list']) . '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]
                ]
            ]
        );
        ?>


        <div class="row" id="regioncontainer"></div>

        <div id="citycontainer"></div>

    </div>
    <div class="box-footer">
        <?= $form->field($model, 'type')->hiddenInput(['value' => Location::TYPE_DELIVERY])->label(false); ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

