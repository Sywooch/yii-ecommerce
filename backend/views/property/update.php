<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Property */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Property') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<?=

$this->render('_form', [
    'model' => $model,
])
?>
