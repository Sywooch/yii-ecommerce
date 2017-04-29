<?php
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

if ($type == 1) {
    $form='Storages';
} else {
    $form='Deliveries';
}
?>
<div class="col-xs-2">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs-left">
        <li class="active"><a href="#regiontab<?=$type?>" data-toggle="tab"><?= Yii::t('shop', 'Region') ?></a>
        </li>
        <li><a href="#bigcitytab<?=$type?>" data-toggle="tab"><?= Yii::t('shop', 'City without region') ?></a></li>
    </ul>
</div>
<div class="col-xs-10">
    <div class="tab-content">
        <div class="tab-pane active" id="regiontab<?=$type?>">

            <div class="col-xs-12">


                <?php echo '<label class="control-label">' . Yii::t('shop', 'Region') . '</label>'; ?>

                <?= Typeahead::widget(
                    [
                        'id' => 'regions',
                        'name' => 'regions',
                        'value' => isset($q) ? ($q) : (''),
                        'options' => ['placeholder' => 'Filter as regions ...'],
                        'pluginOptions' => ['highlight' => true],
                        'pluginEvents' => [
                            "typeahead:select" => 'function( event, ui ) {

                            //if( $("#location-bigcity").val() == "" ){

                            $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/country/formcity') . '",{cid:' . $cid . ',region:ui.value,type:' . $type . '},

                            function( data ) {
                                $( "#citycontainer" ).html(data);
                                $( "#location-region" ).val(ui.value); 
                            });

                        //}

                            }',
                        ],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['country/region-list']) . '?q=%QUERY&cid=' . $cid,
                                    'wildcard' => '%QUERY',

                                ]
                            ]
                        ]
                    ]
                );

                ?>
            </div>

        </div>
        <div class="tab-pane" id="bigcitytab<?=$type?>">
            <?php echo '<label class="control-label">' . Yii::t('shop', 'City without region') . '</label>'; ?>
            <?= Typeahead::widget(
                [
                    'id' => 'location_bigcitys',
                    'name' => 'Location[bigcitys]',
                    'options' => ['placeholder' => 'Filter as bigcity ...'],
                    'pluginOptions' => ['highlight' => true],
                    'pluginEvents' => [
                        "typeahead:select" => "function( event, ui ) { 
                            $('#location-bigcity').val(ui.value); 
                        }",
                    ],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'remote' => [
                                'url' => Url::to(['country/bigcity-list']) . '?q=%QUERY&cid=' . $cid,
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