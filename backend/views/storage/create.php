<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Storage */
/* @var $url string */

$this->title =  Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Storage');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Storages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= $this->render('_form', compact('model', 'url')) ?>

