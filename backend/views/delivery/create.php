<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Delivery */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Delivery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Deliveries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model', 'url')) ?>

