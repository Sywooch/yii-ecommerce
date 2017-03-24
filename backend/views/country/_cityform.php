<?php
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

if ($type==1) {
    $form='Storages';
} else {
    $form='Deliveries';
}


echo '<label class="control-label">' . Yii::t('shop', 'City') . '</label>';
echo Typeahead::widget(
    [
        'id' => 'city',
        'name' => 'city',
        'value' => isset($q) ? ($q) : (''),
        'options' => ['placeholder' => 'Filter as cityes'],
        'pluginOptions' => ['highlight' => true],
        'pluginEvents' => [
            "typeahead:select" => "function( event, ui ) { 
                 $( '#location-city' ).val(ui.value); 
                 }",
        ],
        'dataset' => [
            [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'display' => 'value',
                'remote' => [
                    'url' => Url::to(['country/city-list']) . '?q=%QUERY&cid=' . $cid . '&region=' . $region,
                    'wildcard' => '%QUERY',

                ]
            ]
        ]
    ]
);
