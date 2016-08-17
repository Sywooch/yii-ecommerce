<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\forms\SetForm */
/* @var $products array */

$this->title = Yii::t('app', 'Create Set');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
