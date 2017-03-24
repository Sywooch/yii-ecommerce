<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Delivery;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use webdoka\yiiecommerce\common\models\LocationsPakDeliveries;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Deliveries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Delivery::CREATE_DELIVERY)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Delivery'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">
        <div class="delivery-index">

            <?php Pjax::begin(); ?>    <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'cost',
                    //'storage.name:text:Storage',
                    [
                        'header' => Yii::t('shop', 'Storage'),
                        'attribute' => 'storage.name',
                        'format' => 'text',
                        'value' => 'storage.name',
                    ],
                    [
                    'header' => Yii::t('shop', 'Pak'),
                    'format' => 'raw',
                    'value' => function ($data) {

                            $pak = DeliveriesLocationsPak::find()->where(['id' => $data->pak_id])->one();
                            $return ='';
                        if (isset($pak->name)) {
                            $locations = LocationsPakDeliveries::find()->where(['pak_id' => $pak->id])->joinWith('locations')->all();
                            $return .= '<b>'.$pak->name.'</b><br>';
                            
                            foreach ($locations as $value) {

                                if ($value->locations->region && $value->locations->city) {
                                    $region = $value->locations->region;
                                    $city = $value->locations->city;
                                } elseif ($value->locations->region && !$value->locations->city) {
                                    $region = $value->locations->region;
                                    $city = Yii::t('shop', 'Across');
                                } elseif (!$value->locations->region && $value->locations->city) {
                                    $region = null;
                                    $city = $value->locations->city;

                                } else {
                                    $region = Yii::t('shop', 'Across');
                                    $city = null;
                                }

                                $return .= $value->locations->country;
                                $return .= ($region != null) ? (' >> '.$region) : ('');
                                $return .= ($city != null) ? (' >> '.$city) : ('');
                                $return .= '<br>';

                            }
                        }
                        return $return;
                    }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?></div>
    </div>
</div>

