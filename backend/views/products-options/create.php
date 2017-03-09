<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\ProductsOptions */

$this->title = 'Create Products Options';
$this->params['breadcrumbs'][] = ['label' => 'Products Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-options-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
