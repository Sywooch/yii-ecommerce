<?php

use yii\helpers\Html;

?>
<div class="form-group">
    <div class="row">
        <div class="col-xs-2">
            <?= Html::label($model['name']) ?>
        </div>
        <div class="col-xs-10">
            <?= Html::input('text', 'ProductForm[relFeatures][' . $model['id'] . ']', Html::encode($model['value']), ['class' => 'form-control']) ?>
        </div>
    </div>
</div>