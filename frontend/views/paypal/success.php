<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="row">


    <p><?= Yii::t('shop', 'Paid Name') . '-' . $payer["L_NAME0"] ?></p>
    <p><?= Yii::t('shop', 'Paid Description') . '-' . $payer["L_DESC0"] ?></p>
    <p><?= Yii::t('shop', 'Paid Quantity') . '-' . $payer["L_QTY0"] ?></p>
    <p><?= Yii::t('shop', 'Paid Amount') . '-' . $payer["L_AMT0"] . ' ' . $payer["PAYMENTREQUEST_0_CURRENCYCODE"] ?></p>
    <?php if ($user != ''): ?>
        <p><?= Yii::t('shop', 'From User') . '-' . $user->username ?></p>
    <?php endif ?>


    <?php if (Yii::$app->session->hasFlash('paypal_success')) { ?>
        <?php if (is_array(Yii::$app->session->getFlash('paypal_success'))) { ?>
            <?php foreach (Yii::$app->session->getFlash('paypal_success') as $message) { ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <strong><?= Html::encode($message) ?></strong>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <strong><?= Html::encode(Yii::$app->session->getFlash('paypal_success')) ?></strong>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if (Yii::$app->session->hasFlash('paypal_failure')) { ?>
        <?php if (is_array(Yii::$app->session->getFlash('paypal_failure'))) { ?>
            <?php foreach (Yii::$app->session->getFlash('paypal_failure') as $message) { ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <strong><?= Html::encode($message) ?></strong>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <strong><?= Html::encode(Yii::$app->session->getFlash('paypal_failure')) ?></strong>
            </div>
        <?php } ?>
    <?php } ?>
    <?= Html::a('Return on Test Page', ['/shop/paypal/index'], ['class' => 'pro-details-act-btn btn-text active']) ?>
</div>