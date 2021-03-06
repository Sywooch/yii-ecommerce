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



?>
<div class="box box-primary location-form">


    <div class="box-body">

        <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'type')->hiddenInput(['value' => Location::TYPE_STORAGE])->label(false);?> 
    <?= $form->field($model, 'country')->hiddenInput(['value' =>  $model->isNewRecord ? ('') : $model->country])->label(false);?> 
    <?= $form->field($model, 'region')->hiddenInput(['value' =>  $model->isNewRecord ? ('') : $model->region])->label(false);?>
    <?= $form->field($model, 'bigcity')->hiddenInput(['value' =>  ''])->label(false);?>  
    <?= $form->field($model, 'city')->hiddenInput(['value' =>  $model->isNewRecord ? ('') : $model->city])->label(false);?> 

        <?php
        echo '<label class="control-label">' . Yii::t('shop', 'Country') . '</label>';
        echo Typeahead::widget(
            [
                'id' => 'country',
                'name' => 'country',
                'options' => ['placeholder' => 'Filter as countrys ...'],
                'value' => $model->isNewRecord ? ('') : $model->country,
                'pluginOptions' => ['highlight' => true],
                'pluginEvents' => [

                    "typeahead:select" => 'function( event, ui ) { 

                            $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/formregion') . '",{cid:ui.id, type:1},
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
                        // 'prefetch' => $baseUrl . '/samples/countries.json',

                        'remote' => [
                            'url' => Url::to(['country/country-list']) . '?q=%QUERY&state=%STATE',
                            'wildcard' => '%QUERY'
                        ]
                    ]
                ]
            ]
        );
        ?>


        <div class="row" id="regioncontainer"></div>

        <div id="citycontainer"></div>


        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'index')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="box-footer">


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

 





