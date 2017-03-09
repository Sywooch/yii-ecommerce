<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\PaymentType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Payment Types');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary payment-type-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(PaymentType::CREATE_PAYMENT_TYPE)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Payment Type'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'name',
                'label',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Yii::$app->user->can(PaymentType::VIEW_PAYMENT_TYPE) ?
                                    Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                    ]) : '';
                        },
                                'update' => function ($url, $model, $key) {
                            return Yii::$app->user->can(PaymentType::UPDATE_PAYMENT_TYPE) ?
                                    Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                    ]) : '';
                        },
                                'delete' => function ($url, $model, $key) {
                            return Yii::$app->user->can(PaymentType::DELETE_PAYMENT_TYPE) ?
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
