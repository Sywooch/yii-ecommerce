<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Account */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

