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

            <?= Html::a('Details', ['set/view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton('Add to cart', ['class' => 'btn btn-success']) ?>
        </h2>
    </div>

    <?php $form->end() ?>
</div>