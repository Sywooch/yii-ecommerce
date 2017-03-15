<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\Cities;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Location */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary location-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">

        <?php

        $datacountry = [];

        $countrys = Country::find()->select(['name as value', 'name as label', 'id'])->asArray()->all();
        ?>

        <?= $form->field($model, 'country')->widget(AutoComplete::classname(), [
            'clientOptions' => [
                'dataType' => 'json',
                'autoFill' => true,
                //'source' => $datacountry,
                'source' => $countrys,
                'select' => new JsExpression('function( event, ui ) {

     $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/ajax') . '",
     {
        id:ui.item.id,
        action:"region",
     },

     function( data ) {

$( "#location-region" ).autocomplete( "option", "source", data );

},"json");


$.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/ajax') . '",
     {
        id:ui.item.id,
        action:"state",
     },

     function( data ) {

$( "#location-state" ).autocomplete( "option", "source", data );

},"json");


}')
            ],
            'options' => [
                //'autoIdPrefix' => 'au',
                'class' => 'form-control'
            ]

        ]) ?>


        <?= $form->field($model, 'region')->widget(AutoComplete::classname(), [
            'clientOptions' => [

                'dataType' => 'json',
                'autoFill' => true,
                'source' => '',

                'select' => new JsExpression('function( event, ui ) {

     $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/ajax') . '",
     {
        value:ui.item.value,
        action:"city",
     },

     function( data ) {

$( "#location-city" ).autocomplete( "option", "source", data );

}, "json");


}')

            ],
            'options' => [
                //'autoIdPrefix' => 'au',
                'class' => 'form-control'
            ]
        ]);
        ?>


        <?= $form->field($model, 'state')->widget(AutoComplete::classname(), [
            'clientOptions' => [

                'dataType' => 'json',
                'autoFill' => true,
                'source' => '',

                'select' => new JsExpression('function( event, ui ) {

     $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/ajax') . '",
     {
        value:ui.item.value,
        action:"city",
     },

     function( data ) {

$( "#location-city" ).autocomplete( "option", "source", data );

}, "json");


}')

            ],
            'options' => [
                //'autoIdPrefix' => 'au',
                'class' => 'form-control'
            ]
        ]);
        ?>




        <?= $form->field($model, 'city')->widget(AutoComplete::classname(), [
            'clientOptions' => [
                'dataType' => 'json',

                'source' => '',

            ],
            'options' => [
                //'autoIdPrefix' => 'au',
                'class' => 'form-control'
            ]

        ]) ?>



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
