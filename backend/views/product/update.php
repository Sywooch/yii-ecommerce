<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Product */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Product') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$action = 'update';
?>
<?= $this->render('_form', compact('model', 'dataProvider', 'priceDataProvider', 'action')) ?>

