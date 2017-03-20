<?php

use yii\helpers\Html;

?>

<div class="panel panel-primary">
    <div class="panel-heading"><?= Yii::t('shop', 'Your cart') ?></div>
    <div class="panel-body">
        <p>
            <?= Yii::t('shop', 'Summary') ?>:
            <strong><?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost()) ?></strong>
        </p>
        <p><?= Yii::t('shop', 'Quantity') ?>: <?= Yii::$app->cart->getCount() ?></p>
    </div>
    <div class="panel-footer text-center">
        <?= Html::a(Yii::t('yii', 'View'), ['cart/list'], ['class' => 'btn btn-primary btn-block']) ?>
    </div>
</div>
