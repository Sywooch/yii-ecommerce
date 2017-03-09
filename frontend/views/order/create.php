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

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('shop', 'Return to cart'), ['cart/list'], ['class' => 'btn btn-default']) ?>
    </p>
    <?= $this->render('_form', compact('model', 'orderModel', 'properties')) ?>

</div>
