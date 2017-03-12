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

//$all = ProductsOptionsPrices::find()->groupBy('product_options_id')->where(['product_id' => $model->id])->andWhere('[[status]]=1')->all();


//$curentoption = Yii::$app->request->get('option'.$rootid, 0);


$search = [];
$parent_id = 0;

$optionItem = ProductsOptions::findOne(['id' => $rootid]);

$getchild = $optionItem->children()->all();

foreach ($child as $value) {

//foreach ($all as $value) {

    //$optionItem = ProductsOptions::findOne(['id' => $value->product_options_id]);
    $all = ProductsOptionsPrices::find()->groupBy('product_options_id')->where(['product_id' => $model->id, 'product_options_id' => $value])->andWhere('[[status]]=1')->one();


    $optionItem = ProductsOptions::findOne(['id' => $value]);

    $leaves = $optionItem->leaves()->all();


    if ($leaves == null && $all != null) {

        $leaves = $optionItem->parents()->all();

        foreach ($leaves as $value) {

            if (!in_array($value->id, $search)) {

                $search[] = $value->id;

                if ($value->lvl == 1 || $value->lvl == 2) {
                    echo '<div class="reset"></div>';
                    echo str_repeat('-&nbsp;', $value->lvl) . '<b>' . $value->name . '</b><p>' . $value->description . '</p><br>';
                } else {
                    echo str_repeat('-&nbsp;', $value->lvl) . $value->name . '<p>' . $value->description . '</p><br>';
                }
            }
        }

        $optionItem = ProductsOptions::findOne(['id' => $optionItem->id]);
        $parent = $optionItem->parents(1)->one();

        if ($parent != null && $parent_id != $parent->id) {

            $parent_id = $parent->id;
            echo '<div class="reset"></div>';
        }
        if ($parent == null) {

            echo '<div class="reset"></div>';
        }

        if (isset($optionItem->image) && $optionItem->image != '') {
            $img = Html::img('@web/uploads/po/' . $optionItem->image, ["style" => "width:98px"]);
        } else {
            $img = '';
        }

        if (isset($model->quantity)) {

            $urlparam = [$url, 'id' => $model->id,
                'option' . $rootid . '-' . $parent->id => $optionItem->id,
                'quant' => Html::encode($model->quantity),
                'change' => implode(',', $oldoption)
            ];
            $onclick = '';

        } else {

            $urlparam = [$url, 'id' => $model->id,
                'option[' . $rootid . ']' => $optionItem->id
            ];
            $onclick = 'js:return false;';

        }

        if (isset($parent->id) && isset($_GET['option' . $rootid . '-' . $parent->id])) {

            $curentoption = $_GET['option' . $rootid . '-' . $parent->id];

            $chk = 1;

        } else {

            $curentoption = 0;

            $chk = 0;

        }

        if ($optionItem->id == $curentoption || (in_array($optionItem->id, $oldoption))) {
            $cssclass = 'class="lastdivboxselect"';
        } else {
            $cssclass = 'class="lastdivbox"';
        }
        echo Html::a('<div ' . $cssclass . '>' . $optionItem->name . '<br>' . $img . '</div>', $urlparam, ['class' => 'selectoption optionclick' . $rootid, 'onclick' => $onclick, 'data-id' => $optionItem->id, 'data-parent' => $parent->id]);
    }
}
?>
<?php

$app_js = <<<JS

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

$(document).on('click','.optionclick$rootid',function() {      

    var value = $( this ).data('id');
    var parent = $( this ).data('parent');
    var chk = $chk;
    var url = window.location.toString();
    if(getUrlVars()["option{$rootid}-"+parent] > 0){

        //var reExp = "option{$rootid}-"+parent+"=/\d+";
        var reExp = "option{$rootid}-"+parent+"="+getUrlVars()["option{$rootid}-"+parent];
        var pattern = new RegExp(reExp,'gim');

        var newUrl = url.replace(reExp, "option{$rootid}-"+parent+"=" + value);
    }else{

        var select="option{$rootid}-" + parent;

        var params = {} ;

        params[select]=value ;

        var newUrl = url + ( url.indexOf('?') >= 0 ? '&' : '?' ) + jQuery.param( params );   
    }
    
    location.href = newUrl;
});
JS;
$this->registerJs($app_js);

?>