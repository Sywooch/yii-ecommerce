<?php

use yii\helpers\Html;
use yii\helpers\Url;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Set
 * @var $vatIncluded boolean
 */
?>

<div class="col-xs-12 well set">
    <div class="col-xs-6">
        <h2><?= Html::encode($model->name) ?></h2>
        <table class="table table-striped products">
            <?php foreach ($model->setsProducts as $setProduct) { ?>
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

            <?= Html::a('Details', ['set/view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?= Html::a('Add to cart', ['cart/add', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        </h2>
    </div>
</div>