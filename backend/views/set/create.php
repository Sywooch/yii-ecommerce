<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\forms\SetForm */
/* @var $products array */

$this->title =  Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Set');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Sets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>
