<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="handbook-vat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'percent')->textInput() ?>

    <?= $form->field($model, 'isDefault')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
