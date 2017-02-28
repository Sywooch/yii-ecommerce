<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="lang-form">

            <?php $form = ActiveForm::begin(['action' =>$model->isNewRecord ? ['/admin/shop/lang/trcreate'] : ['/admin/shop/lang/trupdate','id'=>$model->id]]); ?>

            <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

        </div>

                <h2><?=Yii::t('shop', 'Translations') ?></h2>

                <div class="well">
                    <?php Pjax::begin(['id' => 'translate']) ?>

                    <?= ListView::widget([
                        'itemView' => '_translate',
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                        ]); ?>

                        <?php Pjax::end() ?>
                    </div>

    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
