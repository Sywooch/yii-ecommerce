<?php
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

?>

<label class="col-lg-12 control-label"><?=Yii::t('shop', 'City')?></label>
    <div class="input-box">
<?= Typeahead::widget(
    [
        'id' => 'city-'.$type,
        'name' => 'city-'.$type,
        'value' => isset($q) ? ($q) : (''),
        'options' => ['placeholder' => 'Filter as cityes'],
        'pluginOptions' => ['highlight' => true],
        'pluginEvents' => [
            "typeahead:select" => "function( event, ui ) { 
                 $( '#profiles-city-".$type."').val(ui.value); 
                 }",
        ],
        'dataset' => [
            [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'display' => 'value',
                'remote' => [
                    'url' => Url::to(['order/city-list']) . '?q=%QUERY&cid=' . $cid . '&region=' . $region,
                    'wildcard' => '%QUERY',

                ]
            ]
        ]
    ]
);?>
</div>
