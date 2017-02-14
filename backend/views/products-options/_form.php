<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\ProductsOptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-options-form">


<?= $form->field($node, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($node, 'image')->fileInput(); ?>

<?= $form->field($node, 'products_id')->hiddenInput()->label(false);?>



</div>
