<?php

use yii\bootstrap\Nav;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="well well-sm">
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills'],
        'items' => [
            ['label' => 'Categories', 'url' => ['category/index'], 'active' => Yii::$app->controller->id == 'category'],
            ['label' => 'Features', 'url' => ['feature/index'], 'active' => Yii::$app->controller->id == 'feature'],
            ['label' => 'Products', 'url' => ['product/index'],'active' => Yii::$app->controller->id == 'product'],
            ['label' => 'Order', 'url' => ['order/index'],'active' => Yii::$app->controller->id == 'order'],
        ],
    ]) ?>
    <div class="container-fluid">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>

