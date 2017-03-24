<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Location */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Location');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_formd', ['model' => $model, 'pakmodel' => $pakmodel]);

