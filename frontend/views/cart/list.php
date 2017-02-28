<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/*
 * @var $setsDataProvider ActiveDataProvider
 * @var $positionsDataProvider ActiveDataProvider
 */

$this->title = Yii::t('shop','Cart');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('shop','Shop'),
    'url' => ['catalog/index'],
];
$this->params['breadcrumbs'][] = Yii::t('shop','Cart');

?>
<h1><?=Yii::t('shop','Your cart')?></h1>
<p>
    <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> '.Yii::t('shop','Continue purchases'), ['catalog/index'], ['class' => 'btn btn-default']) ?>
    <?php if (Yii::$app->cart->getCount() > 0) { ?>
        <?= Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> '.Yii::t('shop','Create Order'), ['order/create'], ['class' => 'btn btn-primary']) ?>
    <?php } ?>
</p>
<div class="well">
    <h4><?=Yii::t('shop','Summary cost')?>: <?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost()) ?></h4>
    <h4><?=Yii::t('shop','Quantity')?>: <?= Yii::$app->cart->getCount() ?></h4>
</div>

<h2><?=Yii::t('shop','Sets')?>:</h2>
<?= ListView::widget([
    'dataProvider' => $setsDataProvider,
    'summaryOptions' => ['class' => 'well'],
    'itemView' => '_set',
]); ?>

<h2><?=Yii::t('shop','Positions')?>:</h2>
<?= ListView::widget([
    'dataProvider' => $positionsDataProvider,
    'summaryOptions' => ['class' => 'well'],

    'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_position', compact('model','key', 'index'));
        },



]); ?>
