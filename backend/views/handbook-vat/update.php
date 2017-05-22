<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\HandbookVat */

$this->title = Yii::t('app', 'Update') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Handbook Vats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="handbook-vat-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
