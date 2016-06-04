<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/*
 * @var $model \webdoka\yiiecommerce\models\Product
 */
?>

<div class="col-xs-12 well">
    <div class="col-xs-12">
        <h2>
            <?= Html::encode($model->getName()) ?>
            <span class="label label-info">Price: <?= Yii::$app->getModule('shop')->formatter->asCurrency($model->getPrice()) ?></span>
            <span class="label label-info">Quantity: <?= $model->getQuantity() ?></span>
            <?= Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', [
                'cart/remove', 'id' => $model->getId()
            ], [
                'class' => 'btn btn-danger',
                'title' => 'Убрать из списка'
            ]) ?>
        </h2>
        <div><?= Markdown::process($model->features, 'gfm-comment') ?></div>
    </div>
</div>
