<?php
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use Yii;

if ($type == 1) {
    $form = 'Storages';
} else {
    $form = 'Deliveries';
}
?>
<div style="display:block" class="col-xs-12">
    <div class="col-xs-2">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-left">
            <li class="active"><a href="#regiontab<?= $type ?>" data-toggle="tab"><?= Yii::t('shop', 'Region') ?></a>
            </li>
            <li><a href="#bigcitytab<?= $type ?>" data-toggle="tab"><?= Yii::t('shop', 'City without region') ?></a>
            </li>
        </ul>
    </div>
    <div style="display:block" class="col-xs-10">
        <div class="tab-content">
            <div class="tab-pane active" id="regiontab<?= $type ?>">

                <div class="col-xs-12">


                    <?php echo '<label control-label">' . Yii::t('shop', 'Region') . '</label>'; ?>

                    <?= Typeahead::widget(
                        [
                            'id' => 'regions',
                            'name' => 'regions',
                            'value' => isset($region) ? ($region) : (''),
                            'options' => ['placeholder' => 'Filter as regions ...'],
                            'pluginOptions' => ['highlight' => true],
                            'pluginEvents' => [
                                "typeahead:select" => 'function( event, ui ) {

                            //if( $("#location-bigcity").val() == "" ){

                            $.post( "' . Yii::$app->urlManager->createUrl('admin/shop/profiles/formcity') . '",{cid:' . $cid . ',region:ui.value,type:' . $type . ',city:"' . $city . '"},

                            function( data ) {
                                $( "#citycontainer" ).html(data);
                                $( "#profiles-region" ).val(ui.value); 
                            });

                        //}

                            }',
                            ],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'remote' => [
                                        'url' => Url::to(['profiles/region-list']) . '?q=%QUERY&cid=' . $cid,
                                        'wildcard' => '%QUERY',

                                    ]
                                ]
                            ]
                        ]
                    );

                    ?>
                </div>

            </div>
            <div class="tab-pane" id="bigcitytab<?= $type ?>">
                <?php echo '<label class="control-label">' . Yii::t('shop', 'City without region') . '</label>'; ?>
                <?= Typeahead::widget(
                    [
                        'id' => 'location_bigcitys',
                        'name' => 'Location[bigcitys]',
                        'options' => ['placeholder' => 'Filter as bigcity ...'],
                        'pluginOptions' => ['highlight' => true],
                        'pluginEvents' => [
                            "typeahead:select" => "function( event, ui ) { 
                            $('#profiles-city').val(ui.value); 
                        }",
                        ],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['profiles/bigcity-list']) . '?q=%QUERY&cid=' . $cid,
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
</div>