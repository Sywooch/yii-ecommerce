<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\frontend\widgets\CartWidget;
use app\widgets\FrontPager;
use app\widgets\FrontListView;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $categories array */

$title = Yii::t('shop', 'Sets');
$this->title = Html::encode($title);

$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Shop'), 'url' => ['catalog/index']];
$this->params['breadcrumbs'][] = $this->title;

// VAT included
$vatIncluded = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one();
?>


    <div class="row">
        <div class="col-md-9 col-xs-12 float-right">
            <div class="row">

                <?php if (Yii::$app->session->hasFlash('order_success')) { ?>
                    <?php if (is_array(Yii::$app->session->getFlash('order_success'))) { ?>
                        <?php foreach (Yii::$app->session->getFlash('order_success') as $message) { ?>
                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong><?= Html::encode($message) ?></strong>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <strong><?= Html::encode(Yii::$app->session->getFlash('order_success')) ?></strong>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if (Yii::$app->session->hasFlash('order_failure')) { ?>
                    <?php if (is_array(Yii::$app->session->getFlash('order_failure'))) { ?>
                        <?php foreach (Yii::$app->session->getFlash('order_failure') as $message) { ?>
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <strong><?= Html::encode($message) ?></strong>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <strong><?= Html::encode(Yii::$app->session->getFlash('order_failure')) ?></strong>
                        </div>
                    <?php } ?>
                <?php } ?>
                <!-- Shop Top Bar -->
                <div class="shop-top-bar text-center mb-50 col-xs-12">
                    <!-- Product View Mode -->
                    <ul class="view-mode float-left text-left">
                        <li class="active"><a href="#grid-view" data-toggle="tab"><i class="zmdi zmdi-apps"></i></a>
                        </li>
                        <li><a href="#list-view" data-toggle="tab"><i class="zmdi zmdi-view-list"></i></a></li>
                    </ul>
                    <!-- Product Short By -->
                    <div class="pro-short-by text-left">
                        <p><?= Yii::t('shop', 'Sort By'); ?></p>


                        <select class='short'>
                            <option value="name"><?= Yii::t('shop', 'Alphabetically, A-Z'); ?></option>
                            <option value="-name"><?= Yii::t('shop', 'Alphabetically, Z-A'); ?></option>
                            <!--<option value="price">Price, low to high</option>
                            <option value="-price">Price, high to low</option>-->
                        </select>
                    </div>
                    <!-- Product Showing Per Page -->
                    <div class="pro-showing float-right text-left">
                        <p><?= Yii::t('shop', 'Showing'); ?></p>
                        <select class="perpage">
                            <option value="15">15</option>
                            <option value="18">18</option>
                            <option value="21">21</option>
                            <option value="24">24</option>
                            <option value="27">27</option>
                        </select>
                    </div>
                </div>

                <div class="product-tab-content tab-content">


                    <?=
                    FrontListView::widget([
                        'dataProvider' => $dataProvider,
                        'summaryOptions' => [],
                        'options' => ['class' => 'product-tab tab-pane active', 'id' => "grid-view"],
                        'layout' => '{items}',
                        'itemView' => '_set',
                        'viewParams' => compact('vatIncluded')
                    ])
                    ?>



                    <?=
                    FrontListView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => '{items}',
                        'options' => ['class' => 'product-tab tab-pane', 'id' => "list-view"],
                        'summaryOptions' => [],
                        'itemView' => '_setlist',
                        'viewParams' => compact('vatIncluded')
                    ])
                    ?>


                </div>
                <div class="shop-top-bar text-center col-xs-12">
                    <div class="pagination float-left">
                        <?php
                        echo FrontPager::widget([
                            'pagination' => $pages,
                            'options' => ['class' => ''],
                            'prevPageLabel' => '<i class="zmdi zmdi-chevron-left"></i>',
                            'nextPageLabel' => '<i class="zmdi zmdi-chevron-right"></i>',
                            'disabledPageCssClass' => '',
                            'nextPageCssClass' => ''
                        ]);
                        ?>
                    </div>
                    <!-- Product Showing Per Page -->
                    <div class="pro-showing float-right text-left">

                        <p><?= Yii::t('shop', 'Showing'); ?></p>
                        <select class="perpage">
                            <option value="15">15</option>
                            <option value="18">18</option>
                            <option value="21">21</option>
                            <option value="24">24</option>
                            <option value="27">27</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <?php $currentCategory = null; ?>
        <?= $this->render('@app/views/layouts/_sidebar', compact('currentCategory', 'categories')); ?>
    </div>


<?php

$sort = Yii::$app->request->get('sort');
if (!$sort) {
    $chksort = 0;
} else {
    $chksort = 1;
}


$app_js = <<<JS
$(".short").val('$sort');
$(".short").change(function() {

    var value= $(this).val();
    var chksort = $chksort;
    var url = window.location.toString();
    if(chksort==1){
        var reExp = /sort=\\D+/;
        var newUrl = url.replace(reExp, "sort=" + value);
    }else{
      var params = { 'sort':value};  
      var newUrl = url + ( url.indexOf('?') >= 0 ? '&' : '?' ) + jQuery.param( params );  
  }
  location.href=newUrl;
});
JS;
$this->registerJs($app_js);


$perpage = Yii::$app->request->get('per-page', 15);

if (!Yii::$app->request->get('per-page')) {
    $chk = 0;
} else {
    $chk = 1;
}


$app_js = <<<JS
$(".perpage").val('$perpage');
$(".perpage").change(function() {      

    var value= $(this).val();
    var chk = $chk;
    var url = window.location.toString();
    if(chk==1){
        var reExp = /per-page=\\d+/;
        var newUrl = url.replace(reExp, "per-page=" + value);
    }else{
        var params = { 'per-page':value};  
        var newUrl = url + ( url.indexOf('?') >= 0 ? '&' : '?' ) + jQuery.param( params );   
    }
    location.href=newUrl;
});
JS;
$this->registerJs($app_js);


?>


<?php /*
<div id="setList" class="container-fluid">

    <div class="row">
        <div class="col-xs-3">
            <?= CartWidget::widget() ?>
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="active"><?= Html::a(Yii::t('shop', 'Sets'), ['set/index']) ?></li>
                <hr>
                <li role="presentation"><?= Html::a(Yii::t('shop', 'All'), ['catalog/index']) ?></li>
                <?php foreach ($categories as $category) { ?>
                    <li role="presentation"><?= Html::a($category->name, ['catalog/' . $category->slug]) ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-xs-9">
            <?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well well-sm'],
                'itemView' => '_set',
                'viewParams' => compact('vatIncluded')
            ])
            ?>
        </div>
    </div>

</div>
 */
?>