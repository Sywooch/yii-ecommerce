<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\forms\TransactionForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */

$this->registerJs('
    $(function () {

        var $transaction = ".transaction-form",
            $type = "#transactionform-type",
            $profile = "#transactionform-profile",
            $accountId = "#transactionform-account_id",
            $amount = "#transactionform-amount";

        $($transaction).on("change", [$type, $profile, $accountId].join(", "), function () {
            $.pjax.reload({
                url: "' . $url . '",
                data: {
                    amount: $($amount).val(),
                    type: $($type).val(),
                    profile: $($profile).val(),
                    account_id: $($accountId).val(),
                },
                container: "#account",
            });
        });
    });
');
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php Pjax::begin(['id' => 'account']) ?>

        <?= $form->field($model, 'type')->dropDownList(TransactionForm::getTypes()) ?>

        <?php if ($model->type != TransactionForm::ROLLBACK_TYPE) { ?>

            <?= $form->field($model, 'amount')->textInput() ?>

        <?php } ?>

        <?= $form->field($model, 'profile')->dropDownList(ArrayHelper::map(TransactionForm::getUsers(), 'profile.id', 'username'), ['prompt' => 'Choose profile']) ?>

        <?= $form->field($model, 'account_id')->dropDownList(TransactionForm::getAccountsByProfile($model->profile), ['prompt' => 'Choose account']) ?>

        <?php if ($model->type == TransactionForm::WITHDRAW_TYPE) { ?>

            <?= $form->field($model, 'order')->dropDownList(TransactionForm::getOrdersByProfile($model->profile), ['prompt' => 'Choose order']) ?>

        <?php } ?>

        <?php if ($model->type == TransactionForm::ROLLBACK_TYPE) { ?>

            <?= $form->field($model, 'transaction')->dropDownList(TransactionForm::getTransactionsByAccount($model->account_id), ['prompt' => 'Choose transaction']) ?>

        <?php } ?>

    <?php Pjax::end() ?>

    <?=$form->field($model, 'description')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
