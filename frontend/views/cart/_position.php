<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;
use webdoka\yiiecommerce\frontend\widgets\ProductsOptions as OptionWidget;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 */

?>

<div class="col-xs-12 well">
    <div class="col-xs-12">
        <h2>
            <?= Html::encode($model->name) ?>

            <?php if (isset($model->Option_id) && $model->Option_id !=0){

             $parents = $model->getBranchOption($model->Option_id);

             ?>
             <span class="label label-info">Price: <?= Yii::$app->formatter->asCurrency($model->getOptionPrice($model->Option_id)) ?></span>

             <?php }else{ 
                $parents = null;
                ?>

                <span class="label label-info">Price: <?= Yii::$app->formatter->asCurrency($model->realPrice) ?></span>                
                <?php } ?>

                <span class="label label-info">Quantity: <?= Html::encode($model->quantity) ?></span>
                <?= Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', [
                    'cart/remove', 'id' => $model->id, 'option' => (isset($model->Option_id) && $model->Option_id !=0)?($model->Option_id):(0)
                    ], [
                    'class' => 'btn btn-danger',
                    'title' => 'Remove'
                    ]); 
                    ?>

                </h2>
                <table class="table table-striped features">
                    <?php foreach ($model->fullFeatures as $featureProduct) { ?>
                    <tr>
                        <td><?= Html::encode($featureProduct->feature->name) ?></td>
                        <td><?= Html::encode($featureProduct->value) ?></td>
                    </tr>
                    <?php } ?>
                </table>

                        <?php 
                        if($parents !=null){
                            foreach ($parents['branch'] as $parent) { ?>

                            <?= Html::encode($parent->name) ?> » 

                            <?php } ?>
                          <?= Html::encode($parents['option']->name) ?>
                        <?php }
                        ?>
            <a type="button" id="element" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom" data-popover-content="#a1-<?=$index?>">
                Change options
            </a>

            </div>
        </div>

<?php
$oldoptionid=0;

if (isset($model->Option_id)){

    $oldoptionid=$model->Option_id;
}

?>

<div class="hidden col-xs-12" id="a1-<?=$index?>">
  <div class="popover-heading">
    Options from <?=$model->name;?>
</div>

<div class="popover-body">

<?= OptionWidget::widget(['model'=>$model, 'url'=>'cart/update', 'oldoption'=>$oldoptionid]); ?>

</div>
</div>