<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Profiles;
use webdoka\yiiecommerce\common\models\Country;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


if (isset($modcust)) {
    $cid = Country::getCountryId($modcust->country);
    if ($cid) {
        if ($modcust->region != null) {
            $qr = $modcust->region;
        } else {
            $qr = '';
        }

        if ($modcust->city != null) {
            $qc = $modcust->city;
        } else {
            $qc = '';
        }

        $this->registerJs(
            '$.post( "' . Yii::$app->urlManager->createUrl('shop/order/formregion') . '",{cid:'.$cid.', type:'.Profiles::STATUS_CUSTOMER.', q:"'.$qr.'"},
                            function( data ) {    
                            $( "#regioncontainer_'.Profiles::STATUS_CUSTOMER.'" ).html(data);
                            });
            
            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formcity') . '",{cid:' . $cid . ',region:"'.$qr.'", type:'.Profiles::STATUS_CUSTOMER.', q:"'.$qc.'"},

                            function( data ) {
                                $( "#citycontainer_'.Profiles::STATUS_CUSTOMER.'" ).html(data);
                            });

            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formregion') . '",{cid:'.$cid.', type:'.Profiles::STATUS_RECIPIENT.', q:$("#profiles-region-'.Profiles::STATUS_RECIPIENT.'").val()},
                            function( data ) {    
                            $( "#regioncontainer_'.Profiles::STATUS_RECIPIENT.'" ).html(data);
                            });
            
            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formcity') . '",{cid:' . $cid . ',region:"'.$qr.'", type:'.Profiles::STATUS_RECIPIENT.', q:$("#profiles-city-'.Profiles::STATUS_RECIPIENT.'").val()},

                            function( data ) {
                                $( "#citycontainer_'.Profiles::STATUS_RECIPIENT.'" ).html(data);
                            });                


                            '
        );
    }
}

$js = <<< 'SCRIPT'
$("document").ready(function(){ 
       if($("#profiles-bothprofiles").is(":checked")){
           $(".recipient").hide();
       }else{
           $(".recipient").show();
       }
    });
SCRIPT;
$this->registerJs($js);

$js = '
$("document").ready(function(){ 
     if($("#profiles-type-' . Profiles::STATUS_CUSTOMER . '").val()=="' . Profiles::LEGAL_TYPE . '"){
                $(".ur_fiz_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                    $(this).show();
                    });
                $(".fiz_ur_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                    $(this).hide();}); 
    }else{
                $(".ur_fiz_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                    $(this).hide();});
                $(".fiz_ur_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                      $(this).show();
                      }); 
    }
    });';
$this->registerJs($js);

Pjax::begin([
    'id' => 'profiles',
    'enablePushState' => false,
]);
?>

            <div class="welcome-sidebar">
            <div class="sidebar-title"><h4><?= Yii::t('shop', 'Create Profiles') ?></h4></div>
 


            <?php $form = ActiveForm::begin([
                'id' => 'profiles-form',
                'options' => ['class' => 'form-horizontal', 'data-pjax' => false],
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"input-box\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-12 control-label'],
                ],
            ]); ?>

            <div class="box-body">
                <h4><?= Profiles::getStatusLists()[Profiles::STATUS_CUSTOMER] ?></h4>
                <?= $form->field($model, 'country[' . Profiles::STATUS_CUSTOMER . ']', ['template' => '{input}'])->hiddenInput(['value' => isset($modcust) ? ($modcust->country):("")])->label(false); ?>

                <?= $form->field($model, 'region[' . Profiles::STATUS_CUSTOMER . ']', ['template' => '{input}'])->hiddenInput(['value' => isset($modcust) ? ($modcust->region):("")])->label(false); ?>

                <?= $form->field($model, 'city[' . Profiles::STATUS_CUSTOMER . ']', ['template' => '{input}'])->hiddenInput(['value' => isset($modcust) ? ($modcust->city):("")])->label(false); ?>

                <?= $form->field($model, 'user_id[' . Profiles::STATUS_CUSTOMER . ']', ['template' => '{input}'])->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? (Yii::$app->user->identity->id) : ('')])->label(false); ?>

                <?= $form->field($model, 'status[' . Profiles::STATUS_CUSTOMER . ']', ['template' => '{input}'])->hiddenInput(['value' => Profiles::STATUS_CUSTOMER])->label(false); ?>

                <?= $form->field($model, 'type[' . Profiles::STATUS_CUSTOMER . ']')->dropDownList(
                    Profiles::getTypeLists(),
                    [
                        'options' => [isset($modcust) ? ($modcust->type):(Profiles::INDIVIDUAL_TYPE) => ['Selected'=>'selected']],
                        'onchange' => '
                            if($(this).val()=="' . Profiles::LEGAL_TYPE . '"){

                                $(".ur_fiz_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                                    $(this).css("display","block")});
                                    $(".fiz_ur_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                                        $(this).css("display","none")}); 

                                    }else{

                                        $(".ur_fiz_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                                            $(this).css("display","none")});
                                            $(".fiz_ur_' . Profiles::STATUS_CUSTOMER . '").each(function(){
                                                $(this).css("display","block")}); 
                                            }'
                    ]
                ) ?>


                <?= $form->field($model, 'profile_name[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->profile_name):("")]) ?>

                <?= $form->field($model, 'name[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->name):("")]) ?>

                <?= $form->field($model, 'last_name[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->last_name):("")]) ?>


                <label class="col-lg-12 control-label"><?= Yii::t('shop', 'Country') ?></label>
                <div class="input-box">
                    <?php
                    echo Typeahead::widget(
                        [
                            'id' => 'country-' . Profiles::STATUS_CUSTOMER,
                            'name' => 'country-' . Profiles::STATUS_CUSTOMER,
                            'value' => isset($modcust) ? ($modcust->country):(""),
                            'options' => ['placeholder' => 'Filter as countrys ...'],
                            'pluginOptions' => ['highlight' => true],
                            'pluginEvents' => [

                                'typeahead:select' => 'function( event, ui ) { 
                                    $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formregion') . '",
                                    {cid:ui.id, type:' . Profiles::STATUS_CUSTOMER . '},
                                        function( data ) {
                                            $( "#profiles-country-' . Profiles::STATUS_CUSTOMER . '" ).val(ui.value);     
                                            $( "#regioncontainer_' . Profiles::STATUS_CUSTOMER . '" ).html(data);
                                            });
                                    }',
                            ],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    // 'prefetch' => $baseUrl . '/samples/countries.json',

                                    'remote' => [
                                        'url' => Url::to(['order/country-list']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]
                            ]
                        ]
                    );
                    ?>
                </div>

                <div class="prf_regionbox"
                     id="regioncontainer_<?= Profiles::STATUS_CUSTOMER ?>"></div>

                <div class="prf_citybox"
                     id="citycontainer_<?= Profiles::STATUS_CUSTOMER ?>"></div>


                <?= $form->field($model, 'individual_adress[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->individual_adress):("")]) ?>

                <div class="ur_fiz_<?= Profiles::STATUS_CUSTOMER ?>" style="display:<?= isset($modcust) && $modcust->type == Profiles::LEGAL_TYPE ? ('block'):('none')?> ">
                    <?= $form->field($model, 'ur_name[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->ur_name):("")]) ?>

                    <?= $form->field($model, 'legal_adress[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->legal_adress):("")]) ?>

                    <?= $form->field($model, 'inn[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->inn):("")]) ?>

                </div>              

                <?= $form->field($model, 'phone[' . Profiles::STATUS_CUSTOMER . ']')->textInput(['maxlength' => true, 'value' => isset($modcust) ? ($modcust->phone):("")]) ?>
                <div class="prf_checkbox">
                    <?php $model->bothprofiles = isset($modcust) ? (0):(1); ?>

                    <?= $form->field(
                        $model,
                        'bothprofiles',
                        [
                            'template' => "<div class=\"col-lg-1\" style=\"margin-left:5px;\">{input}</div>{label}",
                            'labelOptions' => [
                                'class' => 'col-lg-10 control-label',
                                'style' => 'text-align:left; margin-top:-5px;'
                            ],

                        ]
                    )->checkBox([
                        'uncheck' => 0,
                        'selected' => 1,
                        'value'=>1, 
                        'uncheckValue'=>0,
                        'onchange' => '
      
                            if($(this).is(":checked")){
                                    $(".recipient").hide();
                                 }else{
                                    $(".recipient").show();
                                }'

                    ], false); ?>
                </div>
            </div>
            <div class="recipient" style="display:<?= isset($modcust) ? ('block'):('none') ?>;">
                <?= $this->render('_recprofile', ['model' => isset($modelrec)?($modelrec):($model), 'form' => $form]); ?>
            </div>
            <div class="box-footer">
                <div class="form-group">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <div class="input-box submit-box"><?= Html::submitButton(($model->isNewRecord ? (Yii::t('shop', 'Create')): (Yii::t('shop', 'Update'))) .' '. Yii::t('shop', 'and continue'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> </div>
                  <?php endif; ?>   
                </div>
            </div>
            <?php ActiveForm::end(); ?>




        </div>
<?php Pjax::end(); ?>