<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\PaymentType */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Payment Type') . ': ' . $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Payment Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

