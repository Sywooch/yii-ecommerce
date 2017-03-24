<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Location */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Location') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<?php
if ($model->type == 1) {
    echo $this->render('_formd', ['model' => $model, 'pakmodel' => $pakmodel, 'pakrelation' => $pakrelation]);
} else {
    echo $this->render('_form', ['model' => $model]);
}
