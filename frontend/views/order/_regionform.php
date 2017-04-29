<?php
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

?>
<div class="col-xs-3">
    <ul class="nav nav-tabs tabs-left">
        <li class="active" style="width: 100%">
            <a href="#regiontab<?= $type ?>" data-toggle="tab"><?= Yii::t('shop', 'Region') ?></a>
        </li>
        <li>
            <a href="#bigcitytab<?= $type ?>" data-toggle="tab"><?= Yii::t('shop', 'City without region') ?></a>
        </li>
    </ul>
</div>
<div class="col-xs-9">
    <div class="tab-content">
        <div class="tab-pane active" id="regiontab<?= $type ?>">

                <label class="control-label"><?=Yii::t('shop', 'Region') ?></label>
                <?= Typeahead::widget(
                    [
                        'id' => 'regions-' . $type,
                        'name' => 'regions-' . $type,
                        'value' => isset($q) ? ($q) : (''),
                        'options' => ['placeholder' => 'Filter as regions ...'],
                        'pluginOptions' => ['highlight' => true],
                        'pluginEvents' => [
                            "typeahead:select" => 'function( event, ui ) {


                            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formcity') . '",
                            {cid:' . $cid . ',region:ui.value,type:' . $type . '},

                            function( data ) {
                                $( "#citycontainer_' . $type . '" ).html(data);
                                $( "#profiles-region-' . $type . '" ).val(ui.value); 
                            });


                            }',
                        ],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['order/region-list']) . '?q=%QUERY&cid=' . $cid,
                                    'wildcard' => '%QUERY',

                                ]
                            ]
                        ]
                    ]
                );

                ?>


        </div>
        <div class="tab-pane" id="bigcitytab<?= $type ?>">
            <label class="control-label"><?=Yii::t('shop', 'City without region')?></label>
            <?= Typeahead::widget(
                [
                    'id' => 'bigcitys-' . $type,
                    'name' => 'bigcitys-' . $type,
                    'options' => ['placeholder' => 'Filter as bigcity ...'],
                    'pluginOptions' => ['highlight' => true],
                    'pluginEvents' => [
                        "typeahead:select" => "function( event, ui ) { 
                            $('#profiles-region-" . $type . "').val(''); 
                            $('#citycontainer_" . $type . "').html('');
                            $('#profiles-city-" . $type . "').val(ui.value); 
                        }",
                    ],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'remote' => [
                                'url' => Url::to(['order/bigcity-list']) . '?q=%QUERY&cid=' . $cid,
                                'wildcard' => '%QUERY',

                            ]
                        ]
                    ]
                ]
            );

            ?>

        </div>
    </div>
</div>