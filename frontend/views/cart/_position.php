<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;

/*
 * @var $model \webdoka\yiiecommerce\common\models\Product
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

<div class="hidden col-xs-12" id="a1-<?=$index?>">
  <div class="popover-heading">
    Options from <?=$model->name;?>
</div>

<div class="popover-body">
  <?php 
  $all=ProductsOptionsPrices::find()->groupBy('product_options_id')->where(['product_id'=>$model->id])->andWhere('[[status]]=1')->all();

  $search=[];
  $parent_id=0;
  foreach ($all as $value) {

    $optionItem = ProductsOptions::findOne(['id' => $value->product_options_id]);

    $leaves = $optionItem->leaves()->all();

    if($leaves==null){

      $leaves = $optionItem->parents()->all();

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

     $optionItem = ProductsOptions::findOne(['id' => $optionItem->id]);
     $parent = $optionItem->parents(1)->one();

     if($parent_id!=$parent->id){


      $parent_id=$parent->id;
      echo '<div class="reset"></div>';

    }
    if(isset($optionItem->image) && $optionItem->image !=''){
      $img='<img src="/uploads/po/'.$optionItem->image.'" style="width:98px" />'; 
    }else{
     $img=''; 
   } 

   echo '<a href="'.Url::to(['cart/update','id'=>$model->id,'option'=>$optionItem->id, 'oldoption'=>$oldoptionid,'quant'=>Html::encode($model->quantity)]).'" class="selectoption"><div class="lastdivbox">'.$optionItem->name.'<br>'.$img.'</div></a>';

 }


}
?>

</div>
</div>