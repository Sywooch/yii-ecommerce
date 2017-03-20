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


    <div class="col-md-4 col-sm-6 col-xs-12">

        <?php $form = ActiveForm::begin(['action' => ['set/view', 'id' => $model->id]]) ?>
        <div class="sin-product">
            <?php if ($model->discounts) { ?>
                <span class="pro-label"><?= Yii::t('shop', 'SALE') ?></span>
            <?php } ?>
            <div class="pro-image fix">
                <a href="<?= Url::to(['set/view', 'id' => $model->id]); ?>" class="image"><img
                            src="/frontend/img/product/2.jpg" alt=""/></a>
                <div class="pro-action">


                    <?php foreach ($model->setsProducts as $i => $setProduct) { ?>
                        <?= $form->field($model, 'relSetsProducts[' . $i . '][set_id]')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'relSetsProducts[' . $i . '][product_id]')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'relSetsProducts[' . $i . '][quantity]')->hiddenInput()->label(false) ?>

                    <?php } ?>



                    <?= Html::submitButton('<i class="zmdi zmdi-shopping-cart"></i>', ['class' => 'action-btn cart', "style" => "background-color: transparent;", "onmouseover" => "this.style.backgroundColor='#ff9900';", "onmouseout" => "this.style.backgroundColor='transparent';"]) ?>

                    <a href="#" class="action-btn wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>

                    <?= Html::a('<i class="zmdi zmdi-eye"></i>', ['set/view', 'id' => $model->id], ['class' => 'action-btn quick-view']) ?>

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
                <?= Html::a(Html::encode($model->name), ['set/view', 'id' => $model->id], ['class' => 'pro-title']) ?>
                <h3 class="pro-price">
                <span class="new">
                    <?= Yii::$app->formatter->asCurrency($model->getCostWithDiscounters()) ?>
                </span>
                </h3>
            </div>
        </div>
        <?php $form->end() ?>
    </div>


<?php
/*
<div class="col-xs-12 well set">
    <?php $form = ActiveForm::begin(['action' => ['set/view', 'id' => $model->id]]) ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false)->error(false) ?>

    <div class="col-xs-6">
        <h2><?= Html::encode($model->name) ?></h2>
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
    </div>

    <div class="col-xs-6 price">
        <h2>
            <?= Yii::$app->formatter->asCurrency($model->getCostWithDiscounters()) ?>
            <small><?= $vatIncluded ? '(VAT included)' : '' ?></small>

            <br>

            <?= Html::a(Yii::t('shop', 'Details'), ['set/view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton(Yii::t('shop', 'Add to cart'), ['class' => 'btn btn-success']) ?>
        </h2>
    </div>

    <?php $form->end() ?>
</div>
*/ ?>