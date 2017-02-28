<?php

use yii\helpers\Html;
use yii\grid\GridView;
use webdoka\yiiecommerce\common\models\Unit;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Units');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary unit-index">
<div class="box-header with-border">
        <?php if (Yii::$app->user->can(Unit::CREATE_UNIT)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Unit'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
         </div> 
    <div class="box-body"> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Unit::VIEW_UNIT) ?
                            Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('yii', 'View'),
                            ]) : '';
                    },
                    'update' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Unit::UPDATE_UNIT) ?
                            Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                            ]) : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Unit::DELETE_UNIT) ?
                            Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                'data-method' => 'post',
                            ]) : '';
                    },
                ],
            ],
        ],
    ]); ?>
</div>
</div>
