<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Storage;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Storages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary storage-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Storage::CREATE_STORAGE)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Storage'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div> 
    <div class="box-body">       
        <?php Pjax::begin(); ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'well'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                [
                    'attribute' => 'icon',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->icon ? Html::img($data->iconUrl, ['width' => 20, 'height' => 20]) : '';
                    }
                        ],
                        'location.full',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Yii::$app->user->can(Storage::VIEW_STORAGE) ?
                                            Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                                'title' => Yii::t('yii', 'View'),
                                            ]) : '';
                                },
                                        'update' => function ($url, $model, $key) {
                                    return Yii::$app->user->can(Storage::UPDATE_STORAGE) ?
                                            Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                'title' => Yii::t('yii', 'Update'),
                                            ]) : '';
                                },
                                        'delete' => function ($url, $model, $key) {
                                    return Yii::$app->user->can(Storage::DELETE_STORAGE) ?
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
