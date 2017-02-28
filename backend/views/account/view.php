<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Account;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Account */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Account::UPDATE_ACCOUNT)) { ?>
            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php } ?>
            <?php if (Yii::$app->user->can(Account::DELETE_ACCOUNT)) { ?>
                <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                    ],
                    ]) ?>
                    <?php } ?>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                        'id',
                        'name',
                        'balance',
                        'currency.symbol',
                        'profile.user.username',
                        'default',
                        ],
                        ]) ?>

                        <div class="well">
                            <h2><?= Yii::t('shop', 'Transactions')?></h2>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'summaryOptions' => ['class' => 'well'],
                                'columns' => [
                                'id',
                                'type',
                                'amount',
                                'description',
                                'created_at:datetime',
                                'updated_at:datetime',
                                'account.name',
                                'transaction.id:text:Rollback transaction',
                                ]
                                ]) ?>
                            </div>

                        </div>

                    </div>

