<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use kartik\tree\Module;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;
use webdoka\yiiecommerce\frontend\widgets\ProductsOptions as OptionWidget;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 * @var $vatIncluded boolean
 */
?>
    <div class="col-xs-12">
        <div class="single-product-wrap">
            <div class="single-product-image">
                <div class="pro-thumb float-left">
                    <div class="sin-item"><a href="#pro-img-1" data-toggle="tab"><img
                                    src="/frontend/img/single-product/1.1.jpg"
                                    alt=""/></a></div>
                    <div class="sin-item"><a href="#pro-img-2" data-toggle="tab"><img
                                    src="/frontend/img/single-product/2.1.jpg"
                                    alt=""/></a></div>
                    <div class="sin-item"><a class="active" href="#pro-img-3" data-toggle="tab"><img
                                    src="/frontend/img/single-product/3.1.jpg" alt=""/></a></div>
                    <div class="sin-item"><a href="#pro-img-4" data-toggle="tab"><img
                                    src="/frontend/img/single-product/4.1.jpg"
                                    alt=""/></a></div>
                </div>
                <div class="product-big-image product-big-image-2 tab-content float-left">
                    <div class="tab-pane" id="pro-img-1">
                        <img src="/frontend/img/single-product/1.jpg" alt=""/>
                        <a class="pro-img-popup" href="/frontend/img/single-product/1.jpg"><i
                                    class="zmdi zmdi-search"></i></a>
                    </div>
                    <div class="tab-pane" id="pro-img-2">
                        <img src="/frontend/img/single-product/2.jpg" alt=""/>
                        <a class="pro-img-popup" href="/frontend/img/single-product/2.jpg"><i
                                    class="zmdi zmdi-search"></i></a>
                    </div>
                    <div class="tab-pane active" id="pro-img-3">
                        <img src="/frontend/img/single-product/3.jpg" alt=""/>
                        <a class="pro-img-popup" href="/frontend/img/single-product/3.jpg"><i
                                    class="zmdi zmdi-search"></i></a>
                    </div>
                    <div class="tab-pane" id="pro-img-4">
                        <img src="/frontend/img/single-product/4.jpg" alt=""/>
                        <a class="pro-img-popup" href="/frontend/img/single-product/4.jpg"><i
                                    class="zmdi zmdi-search"></i></a>
                    </div>
                </div>
            </div>
            <?php
            $option = [];

            foreach ($_GET as $key => $value) {

                if (stripos($key, 'option') !== false)

                    $option[] = urldecode($value);

            }
            asort($option);

            ?>
            <div class="single-product-content fix">
                <h3 class="single-pro-title"><?= Html::encode($model->name) ?></h3>
                <div class="single-product-price-ratting fix">
                    <h3 class="single-pro-price float-left">
                    <span class="new">                    

                        <?php
                        if (!empty($option)): ?>
                            <?php $detailprice = $model->getOptionPrice($option) ?>
                            <?= Yii::$app->formatter->asCurrency($detailprice['price']) ?>

                            <small> <?= Yii::t('shop', 'for') ?> <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?></small>
                            <span class="old"><?= Yii::$app->formatter->asCurrency($detailprice['baseprice']) ?></span>
                        <?php else: ?>

                            <?= Yii::$app->formatter->asCurrency($model->realPrice) ?>
                            <small> <?= Yii::t('shop', 'for') ?> <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?></small>
                        <?php endif ?>

                </span>
                        <!--<span class="old">$80.00</span>-->
                    </h3>

                    <p class="single-pro-ratting float-right">
                        <i class="zmdi zmdi-star"></i>
                        <i class="zmdi zmdi-star"></i>
                        <i class="zmdi zmdi-star"></i>
                        <i class="zmdi zmdi-star-half"></i>
                        <i class="zmdi zmdi-star-outline"></i>
                        <span>(24)</span>
                    </p>
                </div>

                <p>There are many variations of passages of Lorem Ipsum available, but the majority have be</p>
                <!--<div class="single-pro-color">
                    <h5>Color</h5>
                    <a href="#" class="color-1"><span></span></a>
                    <a href="#" class="color-2"><span></span></a>
                    <a href="#" class="color-3 active"><span></span></a>
                    <a href="#" class="color-4"><span></span></a>
                    <a href="#" class="color-5"><span></span></a>
                    <a href="#" class="color-6"><span></span></a>
                    <a href="#" class="color-7"><span></span></a>
                </div>-->

                <div class="product-block-size">
                    <div class="pro-block-wrap-2 float-left">
                        <h5><?= Yii::t('shop', 'Feature') ?>:</h5>

                        <?php foreach ($model->fullFeatures as $featureProduct) { ?>

                            <span>
                            <?= Html::encode($featureProduct->feature->name) ?>:
                                <?= Html::encode($featureProduct->value) ?>
                        </span>

                        <?php } ?>
                    </div>
                </div>

                <?php if ($model->discounts) { ?>

                    <div class="product-block-size">
                        <div class="pro-block-wrap-2 float-left">
                            <h5><?= Yii::t('shop', 'Discount') ?>:</h5>
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

                        </div>
                    </div>
                <?php } ?>


                <div class="product-quantity-size fix">
                    <div class="pro-qty-wrap-2 float-left">
                        <h5><?= Yii::t('shop', 'Quantity') ?>:</h5>
                        <div class="pro-qty-2 fix">
                            <input value="1" name="qtybutton" type="text">
                        </div>
                    </div>


                </div>
                <div class="product-quantity-size fix">
                    <div class="pro-qty-wrap-2">
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
                            ?>

                            <?php if ($chk != null): ?>

                                <div class="single-pro-size-2 float-left" style="margin-left:5px;">
                                    <a id="element" data-container="body"
                                       class="btn btn-default"
                                       data-toggle="popover"
                                       data-placement="bottom" data-popover-content="#a<?= $rootid ?>">
                                        <?= $value->name ?>
                                    </a>
                                </div>

                                <div class="hidden col-xs-12" id="a<?= $rootid ?>">
                                    <div class="popover-heading">
                                        <?= Yii::t('shop', 'Options from') ?>: <?= $model->name; ?>
                                    </div>

                                    <div class="popover-body">

                                        <?= OptionWidget::widget(compact('model', 'rootid', 'child')); ?>

                                    </div>
                                </div>


                                <?php
                            endif;
                        }
                        ?>


                    </div>


                </div>
                <?php if (!empty($option)) { ?>

                    <div class="single-product-action-quantity fix" style="padding-bottom:20px;">
                        <b><?= Yii::t('shop', 'Selected') . ' ' . Yii::t('shop', 'Product Options') ?>:</b>
                        <div class="pro-qty-wrap-2">

                            <?php foreach ($option as $value) {

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
                                echo '<p>' . $branch . ' <b>' . Yii::$app->formatter->asCurrency($detailprice['detailoptionsprice'][$value]) . '</b><a href="#" class="btn btn-box-tool remover" onclick="return false;" data-id="option' . $rootid . '-' . $pa->id . '=' . $value . '"><i class="zmdi zmdi-close-circle-o"></i></a></p>';
                            }

                            $options_IDs = implode(',', $option);

                            ?>


                        </div>

                    </div>

                    <?php

                } else {

                    $options_IDs = 0;

                }
                ?>

                <div class="single-product-action-quantity fix">
                    <div class="pro-details-action pro-details-action-2 float-left">

                        <?= Html::a('<i class="zmdi zmdi-shopping-cart"></i>' . Yii::t('shop', 'Add to cart'), ['cart/add', 'id' => $model->id, 'option' => $options_IDs, 'qty' => 1], ['class' => 'pro-details-act-btn btn-text active']) ?>
                        <button class="pro-details-act-btn btn-icon"><i class="zmdi zmdi-favorite-outline"></i></button>
                    </div>
                </div>
                <div class="product-share fix">
                    <a href="#"><i class="zmdi zmdi-facebook"></i></a>
                    <a href="#"><i class="zmdi zmdi-instagram"></i></a>
                    <a href="#"><i class="zmdi zmdi-rss"></i></a>
                    <a href="#"><i class="zmdi zmdi-twitter"></i></a>
                    <a href="#"><i class="zmdi zmdi-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>


<?php

$app_js = <<<JS


$(document).on('click','.remover',function() {      

    var value = $( this ).data('id');
  
    var url = window.location.toString();

        var pattern = new RegExp('&' + value,'gim');

        var newUrl = url.replace(pattern, "");
    
    location.href = newUrl;
});
JS;
$this->registerJs($app_js);


$app_js = <<<JS
$('.pro-qty-2').append('<span class="inc qtybtn-2"><i class="zmdi zmdi-chevron-up"></i></span>');
$('.pro-qty-2').append('<span class="dec qtybtn-2"><i class="zmdi zmdi-chevron-down"></i></span>');
$('.qtybtn-2').on('click', function() {
    var button = $(this);
    var oldValue = button.parent().find('input').val();
    if (button.hasClass('inc')) {
      var newVal = parseFloat(oldValue) + 1;
    } else {
       // Don't allow decrementing below zero
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
        } else {
        newVal = 0;
      }
      }
      $('.pro-details-act-btn')

    var url = $('.pro-details-act-btn').attr('href');

        var reExp = /qty=\\d+/;
        var newUrl = url.replace(reExp, "qty=" + newVal);

        $('.pro-details-act-btn').attr('href', newUrl);

        button.parent().find('input').val(newVal);
});
JS;
$this->registerJs($app_js);
?>

<?PHP /*
<div class="col-xs-12 well">
    <div class="col-xs-6">

        <h2><?= Html::encode($model->name) ?></h2>

        <table class="table table-striped features">
            <?php foreach ($model->fullFeatures as $featureProduct) { ?>
                <tr>
                    <td><?= Html::encode($featureProduct->feature->name) ?></td>
                    <td><?= Html::encode($featureProduct->value) ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="col-xs-6 price">
        <div class="row">
            <?php if ($model->discounts) { ?>
                <div class="col-xs-12">
                    <?php foreach ($model->availableDiscounts as $discount) { ?>
                        <span class="label label-success"><?= Html::encode($discount->name) ?></span>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="col-xs-12">
                <h2>
                    <?php if ((int)Yii::$app->request->get('option', 0) != 0): ?>
                        <?= Yii::$app->formatter->asCurrency($model->getOptionPrice((int)Yii::$app->request->get('option'))) ?>
                        <small> <?= Yii::t('shop', 'for') ?> <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?></small>
                    <?php else: ?>
                        <?= Yii::$app->formatter->asCurrency($model->realPrice) ?>
                        <small> <?= Yii::t('shop', 'for') ?> <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?></small>
                    <?php endif ?>

                </h2>
            </div>
            <div class="col-xs-12">
                <?= Html::a(Yii::t('shop', 'Add to cart'), ['cart/add', 'id' => $model->id, 'option' => (int)Yii::$app->request->get('option', 0)], ['class' => 'btn btn-success']) ?>
                <a type="button" id="element" class="btn btn-default" data-container="body" data-toggle="popover"
                   data-placement="bottom" data-popover-content="#a1">
                    <?= Yii::t('shop', 'Options') ?>
                </a>
            </div>
        </div>
    </div>
</div>
 */
?>