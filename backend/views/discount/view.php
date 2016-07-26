<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Discount;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Discount */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Discount::UPDATE_DISCOUNT)) { ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Discount::DELETE_DISCOUNT)) { ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
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
            'dimension',
            'value',
            'started_at:datetime',
            'finished_at:datetime',
            'count',
        ],
    ]) ?>

</div>
