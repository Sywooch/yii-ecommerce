<?php

use yii\helpers\Html;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 */
?>

<div class="col-xs-12 well">
    <div class="col-xs-12">
        <h2>
            <?= Html::encode($model->getName()) ?>
            <span class="label label-info">Price: <?= Yii::$app->formatter->asCurrency($model->getPrice()) ?></span>
            <span class="label label-info">Quantity: <?= $model->getQuantity() ?></span>
            <?= Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', [
                'cart/remove', 'id' => $model->getId()
            ], [
                'class' => 'btn btn-danger',
                'title' => 'Remove'
            ]) ?>
        </h2>
        <table class="table table-striped features">
            <?php foreach ($model->fullFeatures as $featureProduct) { ?>
                <tr>
                    <td><?= Html::encode($featureProduct->feature->name) ?></td>
                    <td><?= Html::encode($featureProduct->value) ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
