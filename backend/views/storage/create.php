<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Storage */
/* @var $url string */

$this->title = 'Create Storage';
$this->params['breadcrumbs'][] = ['label' => 'Storages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model', 'url')) ?>

</div>
