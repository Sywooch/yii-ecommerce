<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

?>
<div class="fix">
    <ul class="pro-details-tablist fix">
        <li class="active"><a href="#signup"
                              data-toggle="tab"><?= Yii::t('shop', 'Signup') ?></a></li>
        <li><a href="#login" data-toggle="tab"><?= Yii::t('shop', 'Login') ?></a></li>
    </ul>
    <div class="tab-content fix">
        <div id="signup" class="pro-details-tab pro-dsc-tab tab-pane active">
            <?php
            $form = ActiveForm::begin([
                'id' => 'signup-form',
                'options' => ['class' => '', 'data-pjax' => true],
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-12 input-box\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-12 control-label'],
                ],
            ]);
            ?>

            <?= $form->field($modelsignup, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($modelsignup, 'password')->passwordInput() ?>

            <?= $form->field($modelsignup, 'password_repeat')->passwordInput() ?>

            <?= $form->field($modelsignup, 'email')->textInput() ?>

            <?= $form->field($modelsignup, 'captcha')->widget(Captcha::className(), ['captchaAction' => 'order/captcha',
            ]) ?>

            <div class="form-group">
                <div class="col-lg-11">
                    <div class="submit-box"><?= Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => '', 'name' => 'signup-button']) ?> </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
        <!-- Product Info Tab -->
        <div id="login" class="pro-details-tab pro-info-tab tab-pane">


            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal', 'data-pjax' => true],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-12 input-box\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-12 control-label'],
                ],
            ]);
            ?>

            <?= $form->field($modellogin, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($modellogin, 'password')->passwordInput() ?>


            <?= $form->field($modellogin, 'rememberMe',
                [
                'template' => "<div class=\"col-lg-1\" style=\"margin-left:5px;\">{input}</div>{label}",
                'labelOptions' => [
                'class' => 'col-lg-10 control-label',
                'style' => 'text-align:left; margin-top:-5px;'
                ],
                ]
                )->checkBox([], false); ?>


            <div class="form-group">
                <div class="col-lg-11">
                    <div class="input-box"><?= Html::a(Yii::t('app', 'Forgot password?'), ['site/recovery']) ?> </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-11">
                    <div class="submit-box"><?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?> </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


        </div>

    </div>
</div>
