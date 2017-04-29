<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Profiles;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\Cities;
use webdoka\yiiecommerce\common\models\Location;
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Profiles */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $js = <<< 'SCRIPT'
$("document").ready(function(){ 
        $("#profiles-type").on("change", function() {
            $.pjax.reload({container:".profiles-form",url: "/admin/shop/profiles/create?type=" + $(this).val() });  //Reload GridView
        });
    });
SCRIPT;
    $this->registerJs($js);
}


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
            '$.post( "' . Yii::$app->urlManager->createUrl('admin/shop/profiles/formregion') . '",{cid:' . $cid . ', type:1, region:"' . $qr . '", city:"' . $qc . '"},
            function( data ) {    
                $( "#regioncontainer" ).html(data);
            });
            
            $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/profiles/formcity') . '",{cid:' . $cid . ',region:"' . $qr . '", type:1, city:"' . $qc . '"},

            function( data ) {
                $( "#citycontainer" ).html(data);
            });


            '
        );
    }
}


?>
<div class="box box-primary profiles-form">
    <div class="box-body">

        <?php
        Pjax::begin();
        $form = ActiveForm::begin();
        ?>
        <?= $form->field($model, 'country', ['template' => "{input}"])->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'region', ['template' => "{input}"])->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'city', ['template' => "{input}"])->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'user_id', ['template' => "{input}"])->hiddenInput()->label(false); ?>

        <label class="control-label"><?= Yii::t('shop', 'User') ?></label>
        <?php
        echo Typeahead::widget(
            [
                'id' => 'user',
                'name' => 'user',
                'options' => ['placeholder' => 'Filter as countrys ...'],
                'value' => $model->isNewRecord ? ('') : $model->user->username,
                'pluginOptions' => ['highlight' => true],
                'pluginEvents' => [

                    "typeahead:select" => 'function( event, ui ) { $( "#profiles-user_id" ).val(ui.id);}',
                ],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        // 'prefetch' => $baseUrl . '/samples/countries.json',

                        'remote' => [
                            'url' => Url::to(['profiles/users-list']) . '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]
                ]
            ]
        );
        ?>



        <?= $form->field($model, 'default_account_id')->textInput() ?>

        <?= $form->field($model, 'type')->dropDownList(Profiles::getTypeLists()) ?>

        <?= $form->field($model, 'profile_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php if (isset($model->type) && $model->type == Profiles::INDIVIDUAL_TYPE) : ?>

            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        <?php endif ?>
       
<?php if (isset($model->type) && $model->type == Profiles::LEGAL_TYPE) : ?>
        <?= $form->field($model, 'ur_name')->textInput(['maxlength' => true]) ?>
 <?php endif ?>
        <?php if (isset($model->type) && $model->type == Profiles::LEGAL_TYPE) : ?>

            <?= $form->field($model, 'legal_adress')->textInput(['maxlength' => true]) ?>

        <?php endif ?>

        <label class="control-label"><?= Yii::t('shop', 'Country') ?></label>

        <?php
        echo Typeahead::widget(
            [
                'id' => 'country',
                'name' => 'country',
                'options' => ['placeholder' => 'Filter as countrys ...'],
                'value' => $model->isNewRecord ? ('') : $model->country,
                'pluginOptions' => ['highlight' => true],
                'pluginEvents' => [

                    "typeahead:select" => 'function( event, ui ) { 

                $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/profiles/formregion') . '",{cid:ui.id, type:1},
                function( data ) {
                 $( "#profiles-country" ).val(ui.value);     
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
                            'url' => Url::to(['profiles/country-list']) . '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]
                ]
            ]
        );
        ?>

        <div id="regioncontainer"></div>

        <div id="citycontainer"></div>


        <?= $form->field($model, 'individual_adress')->textInput(['maxlength' => true]) ?>
        <?php if (isset($model->type) && $model->type == Profiles::LEGAL_TYPE) : ?>
            <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
        <?php endif ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(Profiles::getStatusLists()) ?>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('shop', 'Create') : Yii::t('shop', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
