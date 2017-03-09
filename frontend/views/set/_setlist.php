<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Set
 * @var $vatIncluded boolean
 */

$model->relSetsProducts = $model->setsProducts;
?>

<div class="sin-list-product clearfix">
    <?php $form = ActiveForm::begin(['action' => ['set/view', 'id' => $model->id]]) ?>
    <div class="pro-image col-lg-4 col-sm-5 col-xs-12">
        <?php if ($model->discounts) { ?>
            <span class="pro-label"><?= Yii::t('shop', 'SALE') ?></span>
        <?php } ?>
        <a href="<?= Url::to(['set/view', 'id' => $model->id]); ?>" class="image fix"><img
                    src="/frontend/img/product/7.jpg" alt=""/></a>
        <div class="pro-action">
            <?= Html::submitButton('<i class="zmdi zmdi-shopping-cart"></i>', ['class' => 'action-btn cart', "style" => "background-color: transparent;", "onmouseover" => "this.style.backgroundColor='#ff9900';", "onmouseout" => "this.style.backgroundColor='transparent';"]) ?>

            <a href="#" class="action-btn wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>

            <?= Html::a('<i class="zmdi zmdi-eye"></i>', ['set/view', 'id' => $model->id], ['class' => 'action-btn quick-view']) ?>
        </div>
    </div>
    <div class="list-pro-details col-lg-8 col-sm-7 col-xs-12">
        <div class="top fix">

            <?= Html::a(Html::encode($model->name), ['set/view', 'id' => $model->id], ['class' => 'pro-title']) ?>


            <p class="pro-ratting float-right">
                <i class="zmdi zmdi-star"></i>
                <i class="zmdi zmdi-star"></i>
                <i class="zmdi zmdi-star"></i>
                <i class="zmdi zmdi-star-half"></i>
                <i class="zmdi zmdi-star-outline"></i>
                <span>(24)</span>
            </p>
        </div>
        <table class="table table-striped products">
            <?php foreach ($model->setsProducts as $i => $setProduct) { ?>
                <?= $form->field($model, 'relSetsProducts[' . $i . '][set_id]')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'relSetsProducts[' . $i . '][product_id]')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'relSetsProducts[' . $i . '][quantity]')->hiddenInput()->label(false) ?>
                <tr>
                    <td><?= Html::encode($setProduct->product->name) ?></td>
                    <td>x <?= Html::encode($setProduct->quantity) ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3 class="pro-price">
            <span class="new">
                <?= Yii::$app->formatter->asCurrency($model->realPrice) ?>
            </span>
            <!--<span class="old">$80.00</span>-->
        </h3>

    </div>
    <?php $form->end() ?>
</div>