<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Price;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Price */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Price::UPDATE_PRICE)) { ?>
            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Price::DELETE_PRICE)) { ?>
            <?=
            Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        <?php } ?>
    </div>
    <div class="box-body">       


        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'label',
                'name',
                'auth_item_name',
            ],
        ])
        ?>

    </div>
</div>
