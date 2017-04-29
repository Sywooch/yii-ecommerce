<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Profiles;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$js = '
$("document").ready(function(){ 
     if($("#profiles-type-' . Profiles::STATUS_RECIPIENT . '").val()=="' . Profiles::LEGAL_TYPE . '"){
                $(".ur_fiz_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                    $(this).show();
                    });
                $(".fiz_ur_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                    $(this).hide();}); 
    }else{
                $(".ur_fiz_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                    $(this).hide();});
                $(".fiz_ur_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                      $(this).show();
                      }); 
    }
    });';
$this->registerJs($js);
?>
<div class="box-body">
    <h4><?= Profiles::getStatusLists()[Profiles::STATUS_RECIPIENT] ?></h4>

    <?= $form->field($model, 'country[' . Profiles::STATUS_RECIPIENT . ']', ['template' => '{input}'])->hiddenInput(['value' =>$model->country])->label(false); ?>

    <?= $form->field($model, 'region[' . Profiles::STATUS_RECIPIENT . ']', ['template' => '{input}'])->hiddenInput(['value' =>$model->region])->label(false); ?>

    <?= $form->field($model, 'city[' . Profiles::STATUS_RECIPIENT . ']', ['template' => '{input}'])->hiddenInput(['value' =>$model->city])->label(false); ?>

    <?= $form->field($model, 'user_id[' . Profiles::STATUS_RECIPIENT . ']', ['template' => '{input}'])->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? (Yii::$app->user->identity->id) : ('')])->label(false); ?>

    <?= $form->field($model, 'status[' . Profiles::STATUS_RECIPIENT . ']', ['template' => '{input}'])->hiddenInput(['value' => Profiles::STATUS_RECIPIENT])->label(false); ?>

    <?= $form->field($model, 'type[' . Profiles::STATUS_RECIPIENT . ']')->dropDownList(
        Profiles::getTypeLists(),
        [
            'options' => [isset($model->type) ? ($model->type):(Profiles::INDIVIDUAL_TYPE) => ['Selected'=>'selected']],
            'onchange' => '
                            if($(this).val()=="' . Profiles::LEGAL_TYPE . '"){

                                $(".ur_fiz_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                                    $(this).css("display","block")});
                                    $(".fiz_ur_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                                        $(this).css("display","none")}); 

                                    }else{

                                        $(".ur_fiz_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                                            $(this).css("display","none")});
                                            $(".fiz_ur_' . Profiles::STATUS_RECIPIENT . '").each(function(){
                                                $(this).css("display","block")}); 
                                            }'
        ]
    ) ?>


    <?= $form->field($model, 'profile_name[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->profile_name]) ?>

    <?= $form->field($model, 'name[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->name]) ?>


    <?= $form->field($model, 'last_name[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->last_name]) ?>



    <label class="col-lg-12 control-label"><?= Yii::t('shop', 'Country') ?></label>
    <div class="input-box">
        <?php
        echo Typeahead::widget(
            [
                'id' => 'country-' . Profiles::STATUS_RECIPIENT,
                'name' => 'country-' . Profiles::STATUS_RECIPIENT,
                'value' => isset($model->country) ? ($model->country):(""),
                'options' => ['placeholder' => 'Filter as countrys ...'],
                'pluginOptions' => ['highlight' => true],
                'pluginEvents' => [

                    'typeahead:select' => 'function( event, ui ) { 
                                    $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formregion') . '",
                                    {cid:ui.id, type:' . Profiles::STATUS_RECIPIENT . '},
                                        function( data ) {
                                            $( "#profiles-country-' . Profiles::STATUS_RECIPIENT . '" ).val(ui.value);     
                                            $( "#regioncontainer_' . Profiles::STATUS_RECIPIENT . '" ).html(data);
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
         id="regioncontainer_<?= Profiles::STATUS_RECIPIENT ?>"></div>

    <div class="prf_citybox"
         id="citycontainer_<?= Profiles::STATUS_RECIPIENT ?>"></div>


    <?= $form->field($model, 'individual_adress[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->individual_adress]) ?>

                <div class="ur_fiz_<?= Profiles::STATUS_RECIPIENT ?>" style="display:<?= isset($model->type) && $model->type == Profiles::LEGAL_TYPE ? ('block'):('none')?>">
                    <?= $form->field($model, 'ur_name[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->ur_name]) ?>


                    <?= $form->field($model, 'legal_adress[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->legal_adress]) ?>


                    <?= $form->field($model, 'inn[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->inn]) ?>

                </div> 

  
    <?= $form->field($model, 'phone[' . Profiles::STATUS_RECIPIENT . ']')->textInput(['maxlength' => true, 'value'=>$model->phone]) ?>

</div>


