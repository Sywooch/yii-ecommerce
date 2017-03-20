<?php

use yii\helpers\Html;
use webdoka\yiiecommerce\common\models\Set;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Set
 */
?>


<tr>
    <td>
        <div class="cart-product text-left fix">
            <img src="/frontend/img/product/2.jpg" alt=""/>
            <div class="details fix">
                <a href="#"><?= Html::encode($model->name) ?></a>
                <table class="table table-striped features">
                    <?php foreach ($model->setsProducts as $cartProduct) { ?>
                        <tr>
                            <td><?= Html::encode($cartProduct->product->name) ?></td>
                            <td>x <?= $cartProduct->quantity ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($cartProduct->product->realPrice) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </td>
    <td><p class="cart-price"><?= Yii::$app->formatter->asCurrency($model->getCostWithDiscounters()) ?></p></td>
    <td><p class="cart-stock">in stock</p></td>
    <td>
        <div class="cart-pro-qunantuty">
            <div class="pro-qty-2 fix">
                <input value="<?= $cartProduct->quantity ?>" name="qtybutton" type="text">
            </div>
        </div>
    </td>
    <td>            <?=
        Html::a('<i class="zmdi zmdi-close"></i>', [
            'cart/remove-set',
            'id' => $model->tmpId,
        ], [
            'class' => 'cart-pro-remove',
            'title' => Yii::t('shop', 'Remove')
        ])
        ?><!--<button class="cart-pro-remove"><i class="zmdi zmdi-close"></i></button>--></td>
</tr>


<?php /*
<div class="col-xs-12 well">
    <div class="col-xs-12">
        <h2>
            <?= Html::encode($model->name) ?>
            <span class="label label-info"><?= Yii::t('shop', 'Price') ?>:
                <?= Yii::$app->formatter->asCurrency($model->getCostWithDiscounters()) ?></span>
            <?=
            Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', [
                'cart/remove-set',
                'id' => $model->tmpId,
                    ], [
                'class' => 'btn btn-danger',
                'title' => Yii::t('shop', 'Remove')
            ])
            ?>
        </h2>
        <table class="table table-striped features">
            <?php foreach ($model->setsProducts as $cartProduct) { ?>
                <tr>
                    <td><?= Html::encode($cartProduct->product->name) ?></td>
                    <td>x <?= $cartProduct->quantity ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($cartProduct->product->realPrice) ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
 */
?>
