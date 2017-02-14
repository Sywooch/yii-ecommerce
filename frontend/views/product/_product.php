<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use kartik\tree\Module;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
 * @var $vatIncluded boolean
 */

$this->registerJs('
    $(function(){
        $("[data-toggle=popover]").popover({
            html : true,
            content: function() {
              var content = $(this).attr("data-popover-content");
              return $(content).children(".popover-body").html();
          },
          title: function() {
              var title = $(this).attr("data-popover-content");
              return $(title).children(".popover-heading").html();
          }
      });
  });    
  ');
  ?>
  <style>
    .popover{
        max-width: 100%;
        min-width: 50%;
    }
    .lastdivbox {
        width: 100px;
        height: 100px;
        border: 1px solid blue;
        float:left;
        margin: 10px;
    }
    .reset{
        clear:both;
    }
</style>

<div class="hidden col-xs-12" id="a1">
  <div class="popover-heading">
    Options from <?=$model->name;?>
</div>

<div class="popover-body">
    <?php

    $all=ProductsOptionsPrices::find()->groupBy('product_options_id')->where(['product_id'=>$model->id])->andWhere('[[status]]=1')->all();

    $search=[];
    $parent_id=0;
    foreach ($all as $value) {

        $countries = ProductsOptions::findOne(['id' => $value->product_options_id]);

        $leaves = $countries->leaves()->all();

        if($leaves==null){

            $leaves = $countries->parents()->all();

            foreach ($leaves as $value) {

                if(!in_array($value->id,$search)){

                    $search[]=$value->id;

                    if($value->lvl==1 || $value->lvl==2){
                        echo '<div class="reset"></div>';
                        echo str_repeat('-&nbsp;', $value->lvl).'<b>'.$value->name.'</b><p>'.$value->description.'</p><br>';

                    }else{
                       echo str_repeat('-&nbsp;', $value->lvl).$value->name.'<p>'.$value->description.'</p><br>';
                   }

               }
           }

           $countries = ProductsOptions::findOne(['id' => $countries->id]);
           $parent = $countries->parents(1)->one();

           if($parent_id!=$parent->id){


            $parent_id=$parent->id;
            echo '<div class="reset"></div>';

        }

        echo '<a href="'.Url::to(['/shop/product/index/','id'=>$model->id,'option'=>$countries->id]).'" class="selectoption"><div class="lastdivbox">'.$countries->name.'</div></a>';

    }


}
?>


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