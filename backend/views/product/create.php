<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Product */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$action = 'create';
?>
<?= $this->render('_form', compact('model', 'dataProvider', 'priceDataProvider', 'action')) ?>

