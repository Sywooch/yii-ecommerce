<?php

use yii\helpers\Html;

use webdoka\yiiecommerce\common\models\Set;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Set
 */
?>

<div class="col-xs-12 well">
    <div class="col-xs-12">
        <h2>
            <?= Html::encode($model->name) ?>
            <span class="label label-info"><?=Yii::t('shop','Price')?>: <?= Yii::$app->formatter->asCurrency($model->getCostWithDiscounters()) ?></span>
            <?= Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', [
                'cart/remove-set',
                'id' => $model->tmpId,
            ], [
                'class' => 'btn btn-danger',
                'title' => Yii::t('shop','Remove')
            ]) ?>
        </h2>
        <table class="table table-striped features">
            <?php foreach ($model->setsProducts as $cartProduct) { ?>
                <tr>
                    <td><?= Html::encode($cartProduct->product->name) ?></td>
                    <td>x <?= $cartProduct->quantity ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($cartProduct->product->realPrice) ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
