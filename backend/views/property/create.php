<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Property */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Property');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=

$this->render('_form', [
    'model' => $model,
])
?>

