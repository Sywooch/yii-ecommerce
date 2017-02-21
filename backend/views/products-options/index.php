<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tree\TreeView;
use kartik\tree\Module;
use yii\helpers\Url;
use webdoka\yiiecommerce\common\models\ProductsOptions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-options-index">

    <h1><?= Html::encode($this->title) ?></h1>



<?php 
    
echo TreeView::widget([
    // single query fetch to render the tree
    // use the Product model you have in the previous step
    'query' => ProductsOptions::find()->addOrderBy('root, lft')->active(),
    'id'=>'products_options',
    'options'=>['id'=>'products_options','enctype' => 'multipart/form-data'],
    'showIDAttribute' => false,
    'nodeAddlViews' => [
        Module::VIEW_PART_2 => '@vendor/webdoka/yii-ecommerce/backend/views/products-options/_form'
    ],
    'nodeActions' => [
       // Module::NODE_MANAGE => Url::to(['/treemanager/node/manage']),
        Module::NODE_SAVE => Url::to(['/admin/shop/products-options/save/']),
       // Module::NODE_REMOVE => Url::to(['/treemanager/node/remove']),
       // Module::NODE_MOVE => Url::to(['/treemanager/node/move']),
    ],

    'headingOptions' => ['label' => 'Options'],
    'fontAwesome' => false,     // optional
    'isAdmin' => ProductsOptions::isAdminTree(),     // optional (toggle to enable admin mode)
    'displayValue' => 1,        // initial display value
    'softDelete' => true,       // defaults to true
    'cacheSettings' => [        
        'enableCache' => false   // defaults to true
    ],
]);
?>

</div>
