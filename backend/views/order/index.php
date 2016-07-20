<?php

use yii\helpers\Html;
use yii\grid\GridView;
use webdoka\yiiecommerce\common\models\Order;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
             'status',
             'created_at:datetime',
             'updated_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Order::VIEW_ORDER) ?
                            Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('yii', 'View'),
                            ]) : '';
                    },
                    'update' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Order::UPDATE_ORDER) ?
                            Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                            ]) : '';
                    },
                ],
            ],
        ],
    ]); ?>
</div>
