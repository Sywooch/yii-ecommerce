<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\PaymentType */

$this->title =  Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Payment Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Payment Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>