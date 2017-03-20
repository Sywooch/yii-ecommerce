<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/*
 * @var $setsDataProvider ActiveDataProvider
 * @var $positionsDataProvider ActiveDataProvider
 */

$this->title = Yii::t('shop', 'Cart');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('shop', 'Shop'),
    'url' => ['catalog/index'],
];
$this->params['breadcrumbs'][] = Yii::t('shop', 'Cart');
?>
<!--<h1><?= Yii::t('shop', 'Your cart') ?></h1>-->
<p>
    <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('shop', 'Continue purchases'), ['catalog/index'], ['class' => 'btn btn-default']) ?>
</p>


<div class="row">
    <div class="col-xs-12">
        <div class="cart-table table-responsive mb-50">
            <h4><?= Yii::t('shop', 'Sets') ?>:</h4>
            <table class="table text-center">
                <thead>
                <tr>
                    <th class="product"><?= Yii::t('shop', 'Set') ?></th>
                    <th class="price"><?= Yii::t('shop', 'Price') ?></th>
                    <th class="stock"><?= Yii::t('shop', 'Stock') ?></th>
                    <th class="qty"><?= Yii::t('shop', 'Quantity') ?></th>
                    <th class="remove"><?= Yii::t('shop', 'Remove') ?></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($setsDataProvider->models as $model) {
                    echo $this->render('_set', compact('model'));
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="cart-table table-responsive mb-50">

            <h4><?= Yii::t('shop', 'Positions') ?>:</h4>
            <table class="table text-center">
                <thead>
                <tr>
                    <th class="product"><?= Yii::t('shop', 'Product') ?></th>
                    <th class="price"><?= Yii::t('shop', 'Price') ?></th>
                    <th class="qty"><?= Yii::t('shop', 'Quantity') ?></th>
                    <th class="price"><?= Yii::t('shop', 'Discount') ?></th>
                    <th class="price"><?= Yii::t('shop', 'Total Price') ?></th>
                    <th class="stock"><?= Yii::t('shop', 'Selected') . ' ' . Yii::t('shop', 'Product Options') ?></th>
                    <th class="remove"><?= Yii::t('shop', 'Remove') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $index = 0;
                foreach ($positionsDataProvider->models as $model) {
                    echo $this->render('_position', compact('model', 'key', 'index'));
                    $index++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="shipping-tax col-md-4 col-xs-12">
        <h4>ESTIMATE SHIPPING AND TAX</h4>
        <form action="#">
            <div class="input-box">
                <select>
                    <option>Country</option>
                    <option>Bangladesh</option>
                    <option>Morocco</option>
                    <option>South Africa</option>
                </select>
            </div>
            <div class="input-box">
                <select>
                    <option>City</option>
                    <option>Dhaka</option>
                    <option>Rabat</option>
                    <option>Cape Town</option>
                </select>
            </div>
            <div class="input-box"><input type="text" placeholder="State/Province"/></div>
            <div class="input-box"><input type="text" placeholder="Zip/Postal Code"/></div>
            <div class="input-box submit-box"><input type="submit" value="Get a Quote"/></div>
        </form>
    </div>
    <div class="product-coupon col-md-4 col-xs-12">
        <h4>COUPON DISCOUNT</h4>
        <p>Enter Your Coupon Code Here</p>
        <form action="#">
            <div class="input-box"><input type="text"/></div>
            <div class="input-box submit-box"><input type="submit" value="Apply Coupon"/></div>
        </form>
    </div>
    <div class="procced-checkout col-md-4 col-xs-12">
        <h4>CART TOTAL</h4>
        <ul>
            <li><span class="name"><?= Yii::t('shop', 'Quantity') ?></span><span
                        class="price"><?= Yii::$app->cart->getCount() ?></span></li>
            <li><span class="name"><?= Yii::t('shop', 'Summary cost') ?></span><span
                        class="price"><?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost()) ?></span></li>
        </ul>
        <?php if (Yii::$app->cart->getCount() > 0) { ?>
            <?= Html::a(Yii::t('shop', 'Create Order'),
                ['order/create'],
                ['class' => 'checkout-link'])
            ?>
        <?php } ?>
    </div>
</div>
