<?php

use yii\helpers\Html;
use webdoka\yiiecommerce\common\models\Lang;

/* @var $model \webdoka\yiiecommerce\common\models\Feature */
?>
<div class="form-group">
    <div class="row">
        <div class="col-xs-2">
            <?= Html::label(Lang::getLangName($model['language'])) ?>
        </div>
        <div class="col-xs-10">
            <?= Html::input('text', 'TranslateMessage[' . $model['language'] . ']', Html::encode($model['value']), ['class' => 'form-control']) ?>
        </div>
    </div>
</div>