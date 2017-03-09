<?php

use yii\helpers\Html;
use yii\grid\GridView;
use webdoka\yiiecommerce\common\models\Transaction;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary transaction-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Transaction::CREATE_TRANSACTION)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Transaction'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'amount',
                'account.profile.user.username',
                'account.name',
                'type',
                'created_at:datetime',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Transaction::VIEW_TRANSACTION) ?
                                    Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                    ]) : '';
                        },
                                'delete' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Transaction::DELETE_TRANSACTION) ?
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
