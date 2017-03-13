<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;
use webdoka\yiiecommerce\frontend\widgets\ProductsOptions as OptionWidget;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 */

$detailprice = $model->getOptionPrice(explode(',', $model->Optid));

if (isset($model->Option_id) && $model->Option_id != 0) {
    $parents = $model->getBranchOption($model->Option_id);
} else {
    $parents = null;
}

$option = [];

foreach ($_GET as $key => $value) {

    if (stripos($key, 'option') !== false)

        $option[] = urldecode($value);

}


?>

<tr>
    <td>
        <div class="cart-product text-left fix">
            <img src="/frontend/img/product/6.jpg" alt=""/>
            <div class="details fix">
                <a href="#"><?= Html::encode($model->name) ?></a>
                <table class="table table-striped features">
                    <?php foreach ($model->fullFeatures as $featureProduct) { ?>
                        <tr>
                            <td><?= Html::encode($featureProduct->feature->name) ?></td>
                            <td><?= Html::encode($featureProduct->value) ?></td>
                        </tr>
                    <?php } ?>
                </table>


            </div>
        </div>
    </td>
    <td><p class="cart-price">
            <?php
            if (isset($model->Optid) && $model->Optid != '') {
                //$parents = $model->getBranchOption($model->Option_id);
                echo Yii::$app->formatter->asCurrency($detailprice['price']);
            } else {
                $parents = null;
                echo Yii::$app->formatter->asCurrency($model->realPrice);
            }
            ?>
        </p></td>
    <td>
        <div class="cart-pro-qunantuty">
            <div class="pro-qty-2 fix">
                <input value="<?= Html::encode($model->quantity) ?>" name="qtybutton" type="text">
            </div>
        </div>
    </td>

    <td><p class="cart-price">
            <?php if ($model->discounts) { ?>

                <?php foreach ($model->availableDiscounts as $discount) {

                    if ($discount->dimension == 'percent') {
                        $dimension = Html::encode($discount->value) . ' %';
                    } elseif ($discount->dimension == 'fixed') {
                        $dimension = Yii::$app->formatter->asCurrency(Html::encode($discount->value));
                    } elseif ($discount->dimension == 'set') {
                        $dimension = Html::encode($discount->value) . ' set';
                    }
                    ?>

                    <span><?= $dimension ?> </span>
                <?php } ?>

            <?php } ?>

        </p></td>
    <td><p class="cart-price">
            <?= Yii::$app->formatter->asCurrency($model->getCostWithDiscounters($model->quantity, $model->Optid)) ?>
        </p></td>


    <td><p class="cart-stock">

            <?php if (!empty($model->Optid)) { ?>

        <table class="table table-striped" style="margin-top: -30px;">
            <tbody>

            <?php foreach (explode(',', $model->Optid) as $value) {

                $parents = $model->getBranchOption($value);

                $branch = '';
                $rootid = '';
                if ($parents != null) {
                    foreach ($parents['branch'] as $parent) {

                        $branch .= Html::encode($parent->name) . ' » ';
                        if ($parent->lvl === 0) {
                            $rootid = $parent->id;
                        }

                    }
                    $branch .= Html::encode($parents['option']->name);
                }
                $pa = $parents['option']->parents(1)->one();

                echo '
                                <tr>
                                    <td>
                                    ' . $branch . ' <b>' . Yii::$app->formatter->asCurrency($detailprice['detailoptionsprice'][$value]) . '</b>
                                    </td>
                                    <td>' .

                    Html::a('<i class="zmdi zmdi-close-circle-o"></i>', [
                        'cart/update', 'id' => $model->id, 'minus' => $value, 'change' => (isset($model->Optid) && $model->Optid != 0) ? ($model->Optid) : (0), 'quant' => $model->quantity,
                    ], [
                        'class' => 'cart-pro-remove',
                        'title' => Yii::t('shop', 'Remove')
                    ])

                    . '
                                    </td>
                                </tr>';
            }

            $options_IDs = $model->Optid;

            ?>


            </tbody>
        </table>

        <?php } else {
            $options_IDs = 0;
        }
        ?>
        </p>

    </td>
    <td>
        <?=
        Html::a('<i class="zmdi zmdi-close"></i>', [
            'cart/remove', 'id' => $model->id, 'option' => (isset($model->Optid) && $model->Optid != 0) ? ($model->Optid) : (0)
        ], [
            'class' => 'cart-pro-remove',
            'title' => Yii::t('shop', 'Remove')
        ]);
        ?>
        <!--<button class="cart-pro-remove"><i class="zmdi zmdi-close"></i></button>-->
    </td>
</tr>
<tr>
    <td>

        <?php

        $roots = ProductsOptions::find()->roots()->all();
        foreach ($roots as $key => $value) {

            $rootid = $value->id;

            $getchild = $value->children()->all();

            $child = [];

            foreach ($getchild as $children) {

                $child[] = $children->id;

            }

            $chk = ProductsOptionsPrices::find()->groupBy('product_options_id')->where(['product_id' => $model->id])->andWhere('[[status]]=1')->andWhere(['in', 'product_options_id', $child])->all();

            if ($chk != null) { ?>

                <div class="single-pro-size-2 float-left" style="margin-left:5px;">
                    <a id="element" data-container="body"
                       class="btn btn-default"
                       data-toggle="popover"
                       data-placement="bottom" data-popover-content="#a<?= $rootid ?>-<?= $index ?>">
                        <?= $value->name ?>
                    </a>
                </div>

                <div class="hidden col-xs-12" id="a<?= $rootid ?>-<?= $index ?>">
                    <div class="popover-heading">
                        <?= Yii::t('shop', 'Options from') ?>: <?= $model->name; ?>
                    </div>

                    <div class="popover-body">

                        <?php
                        $oldoptionid = [];

                        if (isset($model->Optid)) {

                            $oldoptionid = explode(',', $model->Optid);
                        }
                        ?>


                        <?php
                        echo OptionWidget::widget([
                            'model' => $model,
                            'url' => 'cart/update',
                            'oldoption' => $oldoptionid,
                            'rootid' => $rootid,
                            'child' => $child
                        ]);
                        ?>


                    </div>
                </div>


                <?php
            }
        }
        ?>


    </td>
</tr>

<?php /*
<div class="col-xs-12 well">
    <div class="col-xs-12">
        <h2>
            <?= Html::encode($model->name) ?>

            <?php
            if (isset($model->Option_id) && $model->Option_id != 0) {

                $parents = $model->getBranchOption($model->Option_id);
                ?>
                <span class="label label-info"><?= Yii::t('shop', 'Price') ?>:
                    <?= Yii::$app->formatter->asCurrency($model->getOptionPrice($model->Option_id)) ?></span>

                <?php
            } else {
                $parents = null;
                ?>

                <span class="label label-info"><?= Yii::t('shop', 'Price') ?>
                    : <?= Yii::$app->formatter->asCurrency($model->realPrice) ?></span>
            <?php } ?>

            <span class="label label-info"><?= Yii::t('shop', 'Quantity') ?>:
                <?= Html::encode($model->quantity) ?></span>
            <?=
            Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', [
                'cart/remove', 'id' => $model->id, 'option' => (isset($model->Option_id) && $model->Option_id != 0) ? ($model->Option_id) : (0)
            ], [
                'class' => 'btn btn-danger',
                'title' => Yii::t('shop', 'Remove')
            ]);
            ?>

        </h2>
        <table class="table table-striped features">
            <?php foreach ($model->fullFeatures as $featureProduct) { ?>
                <tr>
                    <td><?= Html::encode($featureProduct->feature->name) ?></td>
                    <td><?= Html::encode($featureProduct->value) ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php
        if ($parents != null) {
            foreach ($parents['branch'] as $parent) {
                ?>

                <?= Html::encode($parent->name) ?> »

            <?php } ?>
            <?= Html::encode($parents['option']->name) ?>
        <?php }
        ?>
        <a type="button" id="element" class="btn btn-default" data-container="body" data-toggle="popover"
           data-placement="bottom" data-popover-content="#a1-<?= $index ?>">
            <?= Yii::t('shop', 'Change options') ?>
        </a>

    </div>
</div>
*/
?>
