<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Price */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop_spec', 'Price') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

