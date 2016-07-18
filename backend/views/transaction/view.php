<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Transaction;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Transaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Transaction::DELETE_TRANSACTION)) { ?>
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
            'amount',
            'account.user.username',
            'account.name',
            'type',
            'transaction.id:text:Rollback transaction',
        ],
    ]) ?>

</div>
