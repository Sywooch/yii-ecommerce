<?php

use yii\helpers\Html;

use webdoka\yiiecommerce\common\models\Product;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 */
?>

<div class="col-xs-12 well">
    <div class="col-xs-12">
        <h2>
            <?= Html::encode($model->name) ?>
            <span class="label label-info">Price: <?= Yii::$app->formatter->asCurrency($model->realPrice) ?></span>
            <span class="label label-info">Quantity: <?= Html::encode($model->quantity) ?></span>
            <?= Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', [
                'cart/remove', 'id' => $model->id
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
