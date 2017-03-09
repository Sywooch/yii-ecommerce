<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Category */
/* @var $url string */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Transaction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model', 'url')) ?>

