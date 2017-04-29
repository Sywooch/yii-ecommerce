<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Delivery;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use webdoka\yiiecommerce\common\models\LocationsPakDeliveries;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Discounts on delivery');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Delivery::CREATE_DELIVERY)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Discount on delivery'), ['create'], ['class' => 'btn btn-success']) ?>
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
                    'delivery_value',
                    'type',
                    'discount_value',
                    'discount_value_type',
                    //'storage.name:text:Storage',


                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?></div>
    </div>
</div>

