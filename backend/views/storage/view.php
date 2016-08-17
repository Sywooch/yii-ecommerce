<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Storage;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Storage */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Storages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Storage::UPDATE_STORAGE)) { ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Storage::DELETE_STORAGE)) { ?>
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
            'uid',
            'name',
            'location.full',
            'schedule:ntext',
            'phones',
            'email:email',
            [
                'attribute' => 'icon',
                'format' => 'html',
                'value' => $model->icon ? Html::img($model->iconUrl, ['width' => 20, 'height' => 20]) : ''
            ],
        ],
    ]) ?>

</div>
