<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Transaction;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Transaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary transaction-view">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Transaction::DELETE_TRANSACTION)) { ?>
            <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
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
            'amount',
            'account.profile.user.username',
            'account.name',
            'type',
            'transaction.id:text:Rollback transaction',
        ],
    ]) ?>

</div>
</div>
