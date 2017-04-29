<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Profiles */

$this->title = Yii::t('shop', 'Update {modelClass}: ', [
        'modelClass' => 'Profiles',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('shop', 'Update');
?>

<?= $this->render('_form', ['model' => $model]) ?>


