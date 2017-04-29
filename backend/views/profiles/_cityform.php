<?php
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;


echo '<label class="control-label">' . Yii::t('shop', 'City') . '</label>
<div class="input-box">';
echo Typeahead::widget(
    [
        'id' => 'city',
        'name' => 'city',
        'value' => isset($q) ? ($q) : (''),
        'options' => ['placeholder' => 'Filter as cityes'],
        'pluginOptions' => ['highlight' => true],
        'pluginEvents' => [
            "typeahead:select" => "function( event, ui ) { 
                 $( '#profiles-city' ).val(ui.value); 
                 }",
        ],
        'dataset' => [
            [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'display' => 'value',
                'remote' => [
                    'url' => Url::to(['profiles/city-list']) . '?q=%QUERY&cid=' . $cid . '&region=' . $region,
                    'wildcard' => '%QUERY',

                ]
            ]
        ]
    ]
);
echo "</div>";
