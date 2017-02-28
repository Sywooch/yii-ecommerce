<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Property;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Properties');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary property-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Property::CREATE_PROPERTY)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Property'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
        </div> 
    <div class="box-body">         
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'label',
            'type',
            'profile_type',
            'required',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Property::VIEW_PROPERTY) ?
                            Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('yii', 'View'),
                            ]) : '';
                    },
                    'update' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Property::UPDATE_PROPERTY) ?
                            Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                            ]) : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Property::DELETE_PROPERTY) ?
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
<?php Pjax::end(); ?>
</div>
</div>
