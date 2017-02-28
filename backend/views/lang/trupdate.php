<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Translate') . ': ' . $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Translations'), 'url' => ['trindex']];
$this->params['breadcrumbs'][] = ['label' => $model->message, 'url' => ['trview', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>

    <?= $this->render('_trform', [
        'model' => $model,'dataProvider'=>$dataProvider,
    ]) ?>

