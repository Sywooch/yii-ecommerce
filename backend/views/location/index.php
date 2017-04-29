<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Location;
use webdoka\yiiecommerce\common\models\LocationsPakDeliveries;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Locations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary location-index">
    <div class="box-header with-border">

        <?php if (Yii::$app->user->can(Location::CREATE_LOCATION)) { ?>
            <?= Html::a(Yii::t('app', 'Create') .' '. mb_strtolower (Yii::t('shop_spec', 'Locations storages'),'UTF8'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', 'Create') .' '. mb_strtolower (Yii::t('shop_spec', 'Locations deliveries'),'UTF8'), ['created'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">

        <?php Pjax::begin(); ?>    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'well'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'country',
                'region',
                'city',
                'address',
                'index',
                [
                    //'header' => Yii::t('shop', 'Type'),
                    'attribute' => 'type',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->type == Location::TYPE_STORAGE ? Yii::t('shop', 'Storages location') : Yii::t('shop', 'Deliveries location');
                    }
                ],
                [
                    'header' => Yii::t('shop', 'Pak'),
                    'format' => 'raw',
                    'value' => function ($data) {
                        $location_id = LocationsPakDeliveries::find()->where(['locations_id' => $data->id])->one();
                        if ($location_id != null) {
                            $pak = DeliveriesLocationsPak::find()->where(['id' => $location_id->pak_id])->one();
                        }
                        return isset($pak->name) ? $pak->name : '';
                    }
                ],


                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Location::VIEW_LOCATION) ?
                                Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('yii', 'View'),
                                ]) : '';
                        },
                        'update' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Location::UPDATE_LOCATION) ?
                                Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                ]) : '';
                        },
                        'delete' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Location::DELETE_LOCATION) ?
                                Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                    'data-method' => 'post',
                                ]) : '';
                        },
                    ],
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
