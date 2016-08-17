<?php

use yii\helpers\Html;

?>

<div class="panel panel-primary">
    <div class="panel-heading">Your cart</div>
    <div class="panel-body">
        <p>
            Summary:
            <strong><?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost()) ?></strong>
        </p>
        <p>Quantity: <?= Yii::$app->cart->getCount() ?></p>
    </div>
    <div class="panel-footer text-center">
        <?= Html::a('View', ['cart/list'], ['class' => 'btn btn-primary btn-block']) ?>
    </div>
</div>
