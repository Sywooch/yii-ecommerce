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
/* @var $setDataProvider \yii\data\ArrayDataProvider */
/* @var $transactionDataProvider \yii\data\ArrayDataProvider */
/* @var $historyDataProvider \yii\data\ArrayDataProvider */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">

    <ul class="nav nav-tabs">

        <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"><?=Yii::t('shop', 'Info') ?></a></li>

        <li role="presentation"><a href="#products" aria-controls="products" role="tab" data-toggle="tab"><?=Yii::t('shop', 'Products') ?></a></li>

        <li role="presentation"><a href="#transactions" aria-controls="transactions" role="tab" data-toggle="tab"><?=Yii::t('shop', 'Transactions') ?></a></li>

        <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab"><?=Yii::t('shop', 'History') ?></a></li>

    </ul>

                </div>
                <div class="box-body">

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

                            <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>

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
                    'profile.user.username',
                    'paymentType.name:text:Payment Type',
                    [
                        'attribute' => 'paymentType',
                        'format' => 'text',
                        'value' => $model->paymentType->name,
                    ],
                    'country',
                    [
                        'attribute' => 'tax',
                        'value' => $model->tax ? $model->tax . '%' : null,
                    ]
                ],
            ]) ?>

            <h2><?=Yii::t('shop', 'Details') ?></h2>

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

            <h3><?=Yii::t('shop', 'Sets') ?></h3>

            <?php \yii\widgets\Pjax::begin(['id' => 'sets']); ?>

            <?= GridView::widget([
                'dataProvider' => $setDataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                    'set.name',
                    'set.costWithDiscounters:currency:Cost',
                    [
                        'header' => 'Discount',
                        'value' => function ($model) {
                            return implode(', ', array_map(function ($model) {
                                return $model->name;
                            }, $model->set->discounts));
                        }
                    ],
                ]
            ]) ?>

            <?php \yii\widgets\Pjax::end(); ?>

            <h3><?=Yii::t('shop', 'Products') ?></h3>

            <?php \yii\widgets\Pjax::begin(['id' => 'products']); ?>

            <?= GridView::widget([
                'dataProvider' => $productDataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                'product.category.name',
                'product.name',
                'orderSet.set.name',
                       // 'product.realPrice:currency:Cost',

                [
                'header' => Yii::t('shop', 'Cost from unit'),
                'format' => 'raw',
                'value' => function($model) {
                    if($model->option_id > 0){
                      return Yii::$app->formatter->asCurrency($model->product->getOptionPrice($model->option_id));
                  }else{
                    return Yii::$app->formatter->asCurrency($model->product->realPrice);
                }

            },
            ],


            [
            'header' =>  Yii::t('shop', 'OptionBranch'),
            'format' => 'raw',
            'value' => function($model) {
                if($model->option_id > 0){
                    $parents = $model->product->getBranchOption($model->option_id);
                    $branch='';
                    if($parents !=null){
                        foreach ($parents['branch'] as $parent) {

                            $branch .= Html::encode($parent->name). ' » '; 

                        }
                        return $branch .= Html::encode($parents['option']->name);
                    }
                }


            },
            ],

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
                        'transaction.account.profile.user.username:text:User',
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

</div>
