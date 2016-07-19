<?php

use yii\helpers\Html;

/* @var $model \webdoka\yiiecommerce\common\models\Price */
?>
<div class="form-group">
    <div class="row">
        <div class="col-xs-2">
            <?= Html::label($model['label']) ?>
        </div>
        <div class="col-xs-10">
            <?= Html::input('text', 'ProductForm[relPrices][' . $model['id'] . ']', Html::encode($model['value']), ['class' => 'form-control']) ?>
        </div>
    </div>
</div>