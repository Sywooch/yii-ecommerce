<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Category */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop_spec', 'Category') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<?=

$this->render('_form', [
    'model' => $model,
])
?>

