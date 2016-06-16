<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Feature;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Feature */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feature-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Feature::UPDATE_FEATURE)) { ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Feature::DELETE_FEATURE)) { ?>
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
            'slug',
        ],
    ]) ?>

</div>
