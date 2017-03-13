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
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Product::UPDATE_PRODUCT)) { ?>
            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Product::DELETE_PRODUCT)) { ?>
            <?=
            Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        <?php } ?>
    </div>
    <div class="box-body">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'category_id',
                'name',
                'price',
                'unit.name:html:Unit',
                'discountImplode:text:Discounts',
            ],
        ])
        ?>

        <h2><?= Yii::t('shop', 'Prices') ?></h2>

        <?=
        GridView::widget([
            'dataProvider' => $priceDataProvider,
            'summary' => false,
        ]);
        ?>

        <h2><?= Yii::t('shop', 'Features') ?></h2>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
        ]);
        ?>

    </div>
</div>
