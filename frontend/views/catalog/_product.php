<?php

use yii\helpers\Html;
use \yii\helpers\Url;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 * @var $vatIncluded boolean
 */
?>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="sin-product">
            <?php if ($model->discounts) { ?>
                <span class="pro-label"><?= Yii::t('shop', 'SALE') ?></span>
            <?php } ?>
            <div class="pro-image fix">
                <a href="<?= Url::to(['product/index', 'id' => $model->id]); ?>" class="image"><img
                            src="/frontend/img/product/2.jpg" alt=""/></a>
                <div class="pro-action">
                    <?= Html::a('<i class="zmdi zmdi-shopping-cart"></i>', ['cart/add', 'id' => $model->id], ['class' => 'action-btn cart']) ?>

                    <a href="#" class="action-btn wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>

                    <?= Html::a('<i class="zmdi zmdi-eye"></i>', ['product/index', 'id' => $model->id], ['class' => 'action-btn quick-view']) ?>

                </div>
            </div>
            <div class="pro-details text-center">
                <div class="top fix">
                    <p class="pro-cat float-left"><?= Yii::t('shop', 'Chair') ?></p>
                    <p class="pro-ratting float-right">
                        <i class="zmdi zmdi-star"></i>
                        <i class="zmdi zmdi-star"></i>
                        <i class="zmdi zmdi-star"></i>
                        <i class="zmdi zmdi-star-half"></i>
                        <i class="zmdi zmdi-star-outline"></i>
                        <span>(24)</span>
                    </p>
                </div>
                <?= Html::a(Html::encode($model->name), ['product/index', 'id' => $model->id], ['class' => 'pro-title']) ?>
                <h3 class="pro-price">
                <span class="new">
                    <?= Yii::$app->formatter->asCurrency($model->realPrice) ?>
                    <small> 
                        <?= Yii::t('shop', 'for') ?> <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?>

                    </small>
                </span>
                </h3>
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