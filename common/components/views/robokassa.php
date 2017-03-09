<?php

/* @var $this \yii\web\View */
/* @var $action string */
/* @var $merchant string */
/* @var $amount float */
/* @var $invoiceId integer */
/* @var $description string */
/* @var $currency string */
/* @var $crc string */
/* @var $shopItem integer */
/* @var $isTest integer */

use yii\helpers\Html;
?>

<script>
    window.onload = function () {
        document.form.submit();
    };
</script>

<?= Html::beginForm($action, 'POST', ['name' => 'form']); ?>

<?= Html::hiddenInput('MrchLogin', $merchant); ?>

<?= Html::hiddenInput('OutSum', $amount); ?>

<?= Html::hiddenInput('OutSumCurrency', $currency); ?>

<?= Html::hiddenInput('InvId', $invoiceId); ?>

<?= Html::hiddenInput('Desc', $description); ?>

<?= Html::hiddenInput('SignatureValue', $crc); ?>

<?= Html::hiddenInput('Shp_item', $shopItem); ?>

<?= Html::hiddenInput('IsTest', $isTest); ?>

<?= Html::endForm(); ?>
