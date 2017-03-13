<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \webdoka\yiiecommerce\common\models\Account;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Account::CREATE_ACCOUNT)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Account'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">
        <div class="account-index">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'name',
                    'balance',
                    'currency.symbol',
                    'profile.user.username',
                    'default',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Account::VIEW_ACCOUNT) ?
                                    Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                    ]) : '';
                            },
                            'update' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Account::UPDATE_ACCOUNT) ?
                                    Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                    ]) : '';
                            },
                            'delete' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Account::DELETE_ACCOUNT) ?
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

</div>
