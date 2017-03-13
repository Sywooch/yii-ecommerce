<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Discount;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Discounts');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Discount::CREATE_DISCOUNT)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Discount'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>

    </div>
    <div class="box-body">
        <div class="discount-index">
            <?php Pjax::begin(); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'name',
                    'dimension',
                    'value',
                    'started_at',
                    'finished_at',
                    'count',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Discount::VIEW_DISCOUNT) ?
                                    Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                    ]) : '';
                            },
                            'update' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Discount::UPDATE_DISCOUNT) ?
                                    Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                    ]) : '';
                            },
                            'delete' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Discount::DELETE_DISCOUNT) ?
                                    Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                                        'data-method' => 'post',
                                    ]) : '';
                            },
                        ],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?></div>
    </div>
</div>
