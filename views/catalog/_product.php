<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/*
 * @var $model \webdoka\yiiecommerce\models\Product
 */
?>

<div class="col-xs-12 well well-sm">
    <div class="col-xs-6">
        <h2><?= Html::encode($model->name) ?></h2>
        <div><?= Markdown::process($model->features, 'gfm-comment') ?></div>
    </div>

    <div class="col-xs-6 price">
        <div class="row">
            <div class="col-xs-12"><?= $model->price ?></div>
            <div class="col-xs-12">
                <?= Html::a('Add to cart', ['cart/add', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>