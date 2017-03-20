<?php

use yii\helpers\Html;

?>
<div class="form-group">
    <div class="row">
        <div class="col-xs-2">
            <?= Html::label($model['language']) ?>
        </div>
        <div class="col-xs-10">
            <?= Html::encode($model['value']) ?>
        </div>
    </div>
</div>