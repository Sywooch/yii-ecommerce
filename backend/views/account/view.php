<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Account;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Account */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Account::UPDATE_ACCOUNT)) { ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Account::DELETE_ACCOUNT)) { ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'balance',
            'currency.symbol',
            'user.username',
            'default',
        ],
    ]) ?>

    <div class="well">
        <h2>Transactions</h2>

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
