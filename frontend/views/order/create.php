<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Order */

$this->title = 'Order';
$this->params['breadcrumbs'][] = ['label' => 'Shop', 'url' => ['catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Cart', 'url' => ['cart/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Return to cart', ['cart/list'], ['class' => 'btn btn-default']) ?>
    </p>
    <?= $this->render('_form', compact('model', 'properties')) ?>

</div>
