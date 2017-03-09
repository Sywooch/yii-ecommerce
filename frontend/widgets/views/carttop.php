<?php

use yii\helpers\Html;
use \yii\helpers\Url;

if (Yii::$app->cart->getCount() > 0) {
    $countprduct = '<span class="cart-number">' . Yii::$app->cart->getCount() . '</span>';
} else {
    $countprduct = '';
}


$sets = Yii::$app->cart->getSets();
$positions = Yii::$app->cart->getPositions();
?>
<a href="#" data-toggle="dropdown" class="mini-cart-btn"><span><i
                class="zmdi zmdi-shopping-cart"></i><?= $countprduct ?></span></a>

<div class="mini-cart dropdown-menu right">
    <?php foreach ($sets as $data): ?>
        <div class="mini-cart-product fix">
            <a href="<?= Url::to(['product/index', 'id' => $data->id]); ?>" class="image"><img
                        src="/frontend/img/mini-cart/1.jpg" alt=""/></a>
            <div class="content fix">
                <a href="<?= Url::to(['product/index', 'id' => $data->id]); ?>"
                   class="title"><?= Yii::t('shop', 'Set') ?> <?= $data->name ?></a>

                <?php foreach ($data->setsProducts as $cartProduct) { ?>
                    <p><?= Html::encode($cartProduct->product->name) ?> x <?= $cartProduct->quantity ?></p>
                <?php } ?>
                <p><?= Yii::t('shop', 'Price') ?>
                    : <?= Yii::$app->formatter->asCurrency($data->getCostWithDiscounters()) ?></p>
                <?=
                Html::a('<i class="zmdi zmdi-close"></i>', [
                    'cart/remove-set',
                    'id' => $data->tmpId,
                ], [
                    'class' => 'remove',
                    'title' => Yii::t('shop', 'Remove')
                ])
                ?>
            </div>
        </div>

    <?php endforeach; ?>

    <?php foreach ($positions as $data): ?>
        <div class="mini-cart-product fix">
            <a href="<?= Url::to(['product/index', 'id' => $data->id]); ?>" class="image"><img
                        src="/frontend/img/mini-cart/1.jpg" alt=""/></a>
            <div class="content fix">
                <a href="<?= Url::to(['product/index', 'id' => $data->id]); ?>" class="title"><?= $data->name ?></a>

                <?php foreach ($data->fullFeatures as $featureProduct) { ?>
                    <p><?= Html::encode($featureProduct->feature->name) ?>
                        : <?= Html::encode($featureProduct->value) ?></p>
                <?php } ?>
                <p><?= Yii::t('shop', 'Price') ?>
                    : <?= Yii::$app->formatter->asCurrency($data->getOptionPrice($data->Option_id)) ?></p>
                <?=
                Html::a('<i class="zmdi zmdi-close"></i>', [
                    'cart/remove', 'id' => $data->id, 'option' => (isset($data->Option_id) && $data->Option_id != 0) ? ($data->Option_id) : (0)
                ], [
                    'class' => 'remove',
                    'title' => Yii::t('shop', 'Remove')
                ]);
                ?> <!--<button class="remove"><i class="zmdi zmdi-close"></i></button>-->
            </div>
        </div>

    <?php endforeach; ?>
    <p>
        <?= Yii::t('shop', 'Summary') ?>:
        <strong><?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost()) ?></strong>
    </p>
    <div class="mini-cart-checkout text-center">
        <?= Html::a(Yii::t('yii', 'View'), ['cart/list']) ?>
    </div>
</div>