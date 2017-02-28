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
                    [
                        'attribute' => 'paymentType',
                        'format' => 'text',
                        'value' => isset($model->paymentType->name) ? $model->paymentType->name : '',
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
                    //'set.costWithDiscounters:currency:Cost',
                    [
                        'header' => Yii::t('shop', 'Cost'),
                        'value' => function ($model) {
                        return isset($model->set->costWithDiscounters) ? $model->set->costWithDiscounters : '';
                        }
                    ],

                    [
                        'header' => Yii::t('shop', 'Discount'),
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
                    [
                        'header' => Yii::t('shop_spec', 'Category name'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->product->category->name) ? $model->product->category->name : '';
                    }
                    ],
                    [
                        'header' => Yii::t('shop_spec', 'Product name'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->product->name) ? $model->product->name : '';
                    }
                    ],
                    [
                        'header' => Yii::t('shop_spec', 'Set name'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->orderSet->set->name) ? $model->orderSet->set->name : '';
                    }
                    ],                    

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
                    [
                        'header' => Yii::t('shop', 'Created At'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->transaction->created_at) ? $model->transaction->created_at : '';
                    }
                    ],
                        //'transaction.created_at:datetime:Created At',
                    [
                        'header' => Yii::t('shop', 'Type'),
                        'format' => 'datetime',
                        'value' => function ($model) {

                        return isset($model->transaction->type) ? $model->transaction->type : '';
                    }
                    ],

                       // 'transaction.type:text:Type',

                    [
                        'header' => Yii::t('shop', 'Amount'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->transaction->amount) ? $model->transaction->amount : '';
                    }
                    ],

                     //   'transaction.amount:text:Amount',
                    [
                        'header' => Yii::t('shop', 'Currency'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->transaction->account->currency->symbol) ? $model->transaction->account->currency->symbol : '';
                    }
                    ],
                    //    'transaction.account.currency.symbol:text:Currency',
                    [
                        'header' => Yii::t('shop', 'User'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->transaction->account->profile->user->username) ? $model->transaction->account->profile->user->username : '';
                    }
                    ],
                    //'transaction.account.profile.user.username:text:User',
                    [
                        'header' => Yii::t('shop', 'Description'),
                        'format' => 'text',
                        'value' => function ($model) {

                        return isset($model->transaction->description) ? $model->transaction->description : '';
                    }
                    ],

                        //'transaction.description:text:Description',
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
