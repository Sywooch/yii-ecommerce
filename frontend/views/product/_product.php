<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use kartik\tree\Module;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;
use webdoka\yiiecommerce\frontend\widgets\ProductsOptions as OptionWidget;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 * @var $vatIncluded boolean
 */

  ?>

<div class="hidden col-xs-12" id="a1">
  <div class="popover-heading">
    Options from <?=$model->name;?>
</div>

<div class="popover-body">

<?= OptionWidget::widget(compact('model')); ?>

</div>
</div>

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
            <div class="col-xs-12">
                <h2>
                    <?php if ((int)Yii::$app->request->get('option',0) !=0): ?>
                     <?= Yii::$app->formatter->asCurrency($model->getOptionPrice((int)Yii::$app->request->get('option'))) ?>
                     <small> for <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?></small>   
                 <?php else: ?>
                    <?= Yii::$app->formatter->asCurrency($model->realPrice) ?>
                    <small> for <?= Html::encode($model->unit->name) ?> <?= $vatIncluded ? '(VAT included)' : '' ?></small>
                <?php endif ?>           

            </h2>
        </div>
        <div class="col-xs-12">
        <?= Html::a('Add to cart', ['cart/add', 'id' => $model->id,'option'=>(int)Yii::$app->request->get('option',0)], ['class' => 'btn btn-success']) ?>
            <a type="button" id="element" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom" data-popover-content="#a1">
                Options
            </a>
        </div>
    </div>
</div>
</div>