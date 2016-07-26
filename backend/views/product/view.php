<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use webdoka\yiiecommerce\common\models\Product;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Product */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $priceDataProvider \yii\data\ArrayDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Product::UPDATE_PRODUCT)) { ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Product::DELETE_PRODUCT)) { ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'name',
            'price',
            'unit.name:html:Unit',
            'discountImplode:text:Discounts',
        ],
    ]) ?>

    <h2>Prices</h2>

    <?= GridView::widget([
        'dataProvider' => $priceDataProvider,
        'summary' => false,
    ]); ?>

    <h2>Features</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
    ]); ?>

</div>
