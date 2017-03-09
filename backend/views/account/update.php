<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Account */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Account') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>

<?=

$this->render('_form', [
    'model' => $model,
])
?>

