<?php

use yii\helpers\Html;
use yii\grid\GridView;
use webdoka\yiiecommerce\common\models\Order;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary order-index">
    <div class="box-body">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'well'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'status',
                'total:currency',
                [
                    'header' => Yii::t('shop', 'Country'),
                    'attribute' => 'country',
                ],
                [
                    'header' => Yii::t('shop', 'Tax'),
                    'attribute' => 'tax',
                    'value' => function ($model) {
                        return $model->tax ? $model->tax . '%' : null;
                    },
                ],
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Order::VIEW_ORDER) ?
                                Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('yii', 'View'),
                                ]) : '';
                        },
                    ],
                ],
            ],
        ]);
        ?>
    </div>
</div>
