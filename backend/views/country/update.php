<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Country */

$this->title = 'Update Country: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="account-update">

    <h1><?= Html::encode($model->name) ?> &mdash; <?= Html::encode($model->abbr) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
