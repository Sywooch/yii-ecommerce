<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\ProductsOptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-options-form">


    <?= $form->field($node, 'description')->textarea(['rows' => 6]) ?>

    <?php
    if (isset($node->image) && $node->image != '') {

        echo Html::img('@web/uploads/po/' . $node->image, ["style" => "width:80px"]);
    }
    ?>

    <?= $form->field($node, 'imagef')->fileInput(); ?>


</div>
