<?php

use yii\helpers\Html;
use yii\grid\GridView;
use webdoka\yiiecommerce\common\models\Feature;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Features');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary discount-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Feature::CREATE_FEATURE)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Feature'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>

    </div> 
    <div class="box-body">    
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'well'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                'slug',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Feature::VIEW_FEATURE) ?
                                    Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                    ]) : '';
                        },
                                'update' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Feature::UPDATE_FEATURE) ?
                                    Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                    ]) : '';
                        },
                                'delete' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Feature::DELETE_FEATURE) ?
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
    </div>
</div>
