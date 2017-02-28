<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Discount */

$this->title =  Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Discount');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Discounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
