<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\forms\SetForm */
/* @var $products array */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Set') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Sets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>

<?=

$this->render('_form', [
    'model' => $model,
    'products' => $products,
])
?>
