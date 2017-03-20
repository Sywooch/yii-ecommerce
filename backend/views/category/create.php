<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Category */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=

$this->render('_form', [
    'model' => $model,
])
?>

