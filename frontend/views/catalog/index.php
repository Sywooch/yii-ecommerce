<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
use webdoka\yiiecommerce\common\models\Country;

/*
 * @var $this yii\web\View
 * @var $currentCategory webdoka\yiiecommerce\common\models\Category
 * @var $dataProvider ActiveDataProvider
 * @var $categories Array
 */

$title = 'Shop';
$this->title = Html::encode($title);

if ($currentCategory) {
    $this->params['breadcrumbs'][] = [
        'label' => $this->title,
        'url' => ['catalog/index']
    ];
    $this->params['breadcrumbs'][] = $currentCategory->name;
} else {
    $this->params['breadcrumbs'][] = $this->title;
}

// VAT included
$vatIncluded = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one();

?>

<div class="container-fluid">
    <?php if (Yii::$app->session->hasFlash('order_success')) { ?>
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <strong><?= Yii::$app->session->getFlash('order_success') ?></strong>
        </div>
    <?php } elseif (Yii::$app->session->hasFlash('order_failure')) { ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <strong><?= Yii::$app->session->getFlash('order_failure') ?></strong>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-xs-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Your cart</div>
                <div class="panel-body">
                    <p>
                        Summary:
                        <strong><?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost()) ?></strong>
                    </p>
                    <p>Quantity: <?= Yii::$app->cart->getCount() ?></p>
                </div>
                <div class="panel-footer text-center">
                    <?= Html::a('View', ['cart/list'], ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"<?= !$currentCategory ? ' class="active"' : '' ?>><?= Html::a('All', ['catalog/index']) ?></li>
                <?php foreach ($categories as $category) { ?>
                    <li role="presentation"<?= $currentCategory && $currentCategory->slug == $category->slug ? ' class="active"' : '' ?>>
                        <?= Html::a($category->name, [$category->slug]) ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-xs-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well well-sm'],
                'itemView' => '_product',
                'viewParams' => compact('vatIncluded')
            ]) ?>
        </div>
    </div>
</div>