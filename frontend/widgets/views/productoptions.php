<?php 
  use yii\helpers\Html;
  use \yii\helpers\Url;
  use webdoka\yiiecommerce\common\models\Product;
  use webdoka\yiiecommerce\common\models\ProductsOptions;
  use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;

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

     if($parent !=null && $parent_id != $parent->id){


      $parent_id=$parent->id;
      echo '<div class="reset"></div>';

    }
    if(isset($optionItem->image) && $optionItem->image !=''){
      $img=Html::img('@web/uploads/po/'.$optionItem->image,["style"=>"width:98px"]); 
    }else{
     $img=''; 
   }

   if(isset($model->quantity)){

    $urlparam=[$url,'id'=>$model->id,
    'option'=>$optionItem->id,
    'quant'=>Html::encode($model->quantity),
    'oldoption'=>$oldoption
    ];

  }else{

    $urlparam=[$url,'id'=>$model->id,
    'option'=>$optionItem->id
    ];
  }
  echo Html::a('<div class="lastdivbox">'.$optionItem->name.'<br>'.$img.'</div>', $urlparam, ['class' => 'selectoption']);

}


}
?>