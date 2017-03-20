<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Currency */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Currency');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Currencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?=

$this->render('_form', [
    'model' => $model,
])
?>

