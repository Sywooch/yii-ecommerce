<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/*
 * @var $setsDataProvider ActiveDataProvider
 * @var $positionsDataProvider ActiveDataProvider
 */

$this->title = 'Cart';
$this->params['breadcrumbs'][] = [
    'label' => 'Shop',
    'url' => ['catalog/index'],
];
$this->params['breadcrumbs'][] = 'Cart';

?>
<h1>Your cart</h1>
<p>
    <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Continue purchases', ['catalog/index'], ['class' => 'btn btn-default']) ?>
    <?php if (Yii::$app->cart->getCount() > 0) { ?>
        <?= Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> Create Order', ['order/create'], ['class' => 'btn btn-primary']) ?>
    <?php } ?>
</p>
<div class="well">
    <h4>Summary cost: <?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost()) ?></h4>
    <h4>Quantity: <?= Yii::$app->cart->getCount() ?></h4>
</div>

<h2>Sets:</h2>
<?= ListView::widget([
    'dataProvider' => $setsDataProvider,
    'summaryOptions' => ['class' => 'well'],
    'itemView' => '_set',
]); ?>

<h2>Positions:</h2>
<?= ListView::widget([
    'dataProvider' => $positionsDataProvider,
    'summaryOptions' => ['class' => 'well'],
   /* 'itemView' => '_position',
        'viewParams'   => [
        'count' => $index // How to get this variable?
    ],*/
    'itemView' => function ($model, $key, $index, $widget) {

           
            return $this->render('_position', compact('model','key', 'index'));
        },



]); ?>
