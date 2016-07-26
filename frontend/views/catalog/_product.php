<?php

use yii\helpers\Html;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 */
?>

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
            <div class="col-xs-12"><h2><?= Yii::$app->formatter->asCurrency($model->realPrice) ?> <small> for <?= Html::encode($model->unit->name) ?></small></h2></div>
            <div class="col-xs-12">
                <?= Html::a('Add to cart', ['cart/add', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>