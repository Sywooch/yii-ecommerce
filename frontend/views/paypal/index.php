<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$title = Yii::t('shop', 'Test PayPal');
$this->title = Html::encode($title);

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="paypal-form-wrapper fix col-xs-6">
        <div class="paypal-form">
            <?php $form = ActiveForm::begin(['action' => ['/shop/paypal/pay'], 'method' => 'post']); ?>

            <div class="input-box">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Pay Name'])->label(false) ?>
            </div>

            <div class="input-box-2 fix">
                <div class="input-box float-left">
                    <?= $form->field($model, 'summ')->textInput(['maxlength' => true, 'placeholder' => 'Sum Pay'])->label(false) ?>
                </div>
                <div class="input-box float-left">
                    <?= $form->field($model, 'currency')->dropDownList([
                        'USD' => 'U.S. Dollar',
                        'EUR' => 'Euro',
                        'JPY' => 'Japanese Yen',
                        'RUB' => 'Russian Ruble',
                        'GBP' => 'Pound Sterling',
                    ])->label(false); ?>
                </div>
            </div>

            <div class="input-box paypal-box fix">
                <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder' => 'Pay Description'])->label(false) ?>
            </div>
            <div class="input-box submit-box fix">
                <?= Html::submitButton('Test Pay', ['class' => 'pro-details-act-btn btn-text active']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

