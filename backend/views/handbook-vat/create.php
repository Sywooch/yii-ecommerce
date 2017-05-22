<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\HandbookVat */

$this->title = Yii::t('app', 'Create Handbook Vat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Handbook Vats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="handbook-vat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
