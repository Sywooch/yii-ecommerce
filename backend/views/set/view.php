<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Set;

/* @var $this yii\web\View */
/* @var $model app\models\Set */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Set::UPDATE_SET)) { ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Set::DELETE_SET)) { ?>
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
        ],
    ]) ?>

</div>
