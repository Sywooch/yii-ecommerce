<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Profiles */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('shop', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('shop', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('shop', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'default_account_id',
            'type',
            'name',
            'last_name',
            'ur_name',
            'legal_adress',
            'country',
            'region',
            'city',
            'individual_adress',
            'inn',
            'phone',
            'status',
        ],
    ]) ?>

</div>
