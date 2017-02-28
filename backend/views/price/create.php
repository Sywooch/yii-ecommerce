<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Price */

$this->title =  Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Price');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

