<?php

use yii\helpers\Html;
use \yii\helpers\Url;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 * @var $vatIncluded boolean
 */
?>

<div class="sin-list-product clearfix">
    <div class="pro-image col-lg-4 col-sm-5 col-xs-12">
        <?php if ($model->discounts) { ?>
            <span class="pro-label"><?= Yii::t('shop', 'SALE') ?></span>
        <?php } ?>
        <a href="<?= Url::to(['product/index', 'id' => $model->id]); ?>" class="image fix"><img
                    src="/frontend/img/product/7.jpg" alt=""/></a>
        <div class="pro-action">
            <?= Html::a('<i class="zmdi zmdi-shopping-cart"></i>', ['cart/add', 'id' => $model->id], ['class' => 'action-btn cart']) ?>

            <a href="#" class="action-btn wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>

            <?= Html::a('<i class="zmdi zmdi-eye"></i>', ['product/index', 'id' => $model->id], ['class' => 'action-btn quick-view']) ?>
        </div>
    </div>
    <div class="list-pro-details col-lg-8 col-sm-7 col-xs-12">
        <div class="top fix">

            <?= Html::a(Html::encode($model->name), ['product/index', 'id' => $model->id], ['class' => 'pro-title']) ?>
            <p class="pro-ratting float-right">
                <i class="zmdi zmdi-star"></i>
                <i class="zmdi zmdi-star"></i>
                <i class="zmdi zmdi-star"></i>
                <i class="zmdi zmdi-star-half"></i>
                <i class="zmdi zmdi-star-outline"></i>
                <span>(24)</span>
            </p>
        </div>
        <h3 class="pro-price">
            <span class="new">
                <?= Yii::$app->formatter->asCurrency($model->realPrice) ?>
                <small> 
                    <?= Yii::t('shop', 'for') ?> <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?>

                </small>
            </span>
            <!--<span class="old">$80.00</span>-->
        </h3>
        <div class="list-pro-dec">
            <div class="row">
                <div class="col-xs-6">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /*
  <div class="col-xs-12 well">
  <div class="col-xs-6">
  <h2><a href="<?= Url::to(['product/index','id' => $model->id]);?>"><?= Html::encode($model->name) ?></a></h2>
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
  <?= Yii::$app->formatter->asCurrency($model->realPrice) ?>
  <small> <?= Yii::t('shop','for')?> <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?></small>
  </h2>
  </div>
  <div class="col-xs-12">
  <?= Html::a(Yii::t('shop','Add to cart'), ['cart/add', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
  </div>
  </div>
  </div>
  </div>
 */
?>                           