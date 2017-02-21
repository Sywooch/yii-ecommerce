<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TranslateMessage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Translate Message',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translate Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="translate-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
