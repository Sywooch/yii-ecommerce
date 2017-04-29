<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \yii\base\DynamicModel */
/* @var $orderModel webdoka\yiiecommerce\common\models\Order */

$this->title = Yii::t('shop', 'Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Shop'), 'url' => ['catalog/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Cart'), 'url' => ['cart/list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-create">

    <?= $this->render('_form_welcome', compact('model', 'modellogin', 'modcust', 'modelrec', 'modelsignup', 'modelre')) ?>

</div>