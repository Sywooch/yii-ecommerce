<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Language') . ': ' . $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

