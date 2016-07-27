<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use webdoka\yiiecommerce\common\models\Order;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Order */
/* @var $contactDataProvider \yii\data\ArrayDataProvider */
/* @var $productDataProvider \yii\data\ArrayDataProvider */
/* @var $transactionDataProvider \yii\data\ArrayDataProvider */
/* @var $historyDataProvider \yii\data\ArrayDataProvider */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="nav nav-tabs">

        <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a></li>

        <li role="presentation"><a href="#products" aria-controls="products" role="tab" data-toggle="tab">Products</a></li>

        <li role="presentation"><a href="#transactions" aria-controls="transactions" role="tab" data-toggle="tab">Transactions</a></li>

        <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>

    </ul>

    <br>

    <div class="tab-content" role="tablist">

        <div role="tabpanel" class="tab-pane fade in active" id="info">

            <?php if (Yii::$app->user->can(Order::UPDATE_ORDER)) { ?>

                <div class="location-form">

                    <?php $form = ActiveForm::begin(['method' => 'POST', 'action' => ['status', 'id' => $model->id]]) ?>

                    <div class="row">

                        <div class="col-md-10">

                            <?= $form->field($model, 'status')->dropDownList(Order::getStatuses())->label(false) ?>

                        </div>

                        <div class="col-md-2">

                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-block']) ?>

                        </div>

                    </div>

                    <?php $form->end() ?>

                </div>

            <?php } ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'status',
                    'total:currency',
                    'created_at:datetime',
                    'updated_at:datetime',
                    'user.username',
                    'paymentType.name:text:Payment Type',
                    'country',
                    [
                        'attribute' => 'tax',
                        'value' => $model->tax ? $model->tax . '%' : null,
                    ]
                ],
            ]) ?>

            <h2>Details</h2>

            <?php \yii\widgets\Pjax::begin(['id' => 'details']); ?>

                <?= GridView::widget([
                    'dataProvider' => $contactDataProvider,
                    'showHeader' => false,
                    'summary' => false,
                    'columns' => [
                        'property.label',
                        'value'
                    ]
                ]) ?>

            <?php \yii\widgets\Pjax::end(); ?>

        </div>

        <div role="tabpanel" class="tab-pane fade" id="products">

            <?php \yii\widgets\Pjax::begin(['id' => 'products']); ?>

                <?= GridView::widget([
                    'dataProvider' => $productDataProvider,
                    'summaryOptions' => ['class' => 'well'],
                    'columns' => [
                        'product.category.name',
                        'product.name',
                        'product.realPrice',
                        'quantity',
                        'product.unit.name',
                    ]
                ]) ?>

            <?php \yii\widgets\Pjax::end(); ?>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="transactions">

            <?php \yii\widgets\Pjax::begin(['id' => 'transactions']); ?>

                <?= GridView::widget([
                    'dataProvider' => $transactionDataProvider,
                    'summaryOptions' => ['class' => 'well'],
                    'columns' => [
                        'transaction.created_at:datetime:Created At',
                        'transaction.type:text:Type',
                        'transaction.amount:text:Amount',
                        'transaction.account.currency.symbol:text:Currency',
                        'transaction.account.user.username:text:User',
                        'transaction.description:text:Description',
                    ]
                ]) ?>

            <?php \yii\widgets\Pjax::end(); ?>

        </div>

        <div role="tabpanel" class="tab-pane fade" id="history">

            <?php \yii\widgets\Pjax::begin(['id' => 'history']); ?>

                <?= GridView::widget([
                    'dataProvider' => $historyDataProvider,
                    'summaryOptions' => ['class' => 'well'],
                    'columns' => [
                        'id',
                        'status',
                        'created_at:datetime',
                    ]
                ]) ?>

            <?php \yii\widgets\Pjax::end(); ?>

        </div>

    </div>

</div>
