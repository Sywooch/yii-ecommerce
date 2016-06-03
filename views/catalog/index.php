<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/*
 * @var $this yii\web\View
 * @var $dataProvider ActiveDataProvider
 */

$title = $category === null ? 'Welcome!' : $category->title;
$this->title = Html::encode($title);
?>

<h1>
    <?= Html::encode($title) ?>
    <div class="pull-right"><span class="glyphicon glyphicon-shopping-cart"></span> <?= Yii::$app->cart->getCount() ?></div>
</h1>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well well-sm'],
                'itemView' => '_product',
            ]) ?>
        </div>
    </div>
</div>