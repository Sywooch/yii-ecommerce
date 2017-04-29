<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\forms\StorageForm;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use \yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\components\PostApi;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Delivery */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */

    ?>
    <div class="delivery-form">   
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4><?= Yii::t('shop', 'Delivery info') ?></h4>
        </div>
        <div class="box-body">
            

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'delivery_value')->textInput() ?>

                <?= $form->field($model, 'type')->dropDownList($model->typeLists) ?>


                <?= $form->field($model, 'discount_value')->textInput() ?>

                <?= $form->field($model, 'discount_value_type')->dropDownList($model->valueTypeLists) ?>

            
        </div>

                                <div class="box-footer">
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>

    </div>



        
                    <?php ActiveForm::end(); ?>
</div>  