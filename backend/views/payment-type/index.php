<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\PaymentType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(PaymentType::CREATE_PAYMENT_TYPE)) { ?>
            <?= Html::a('Create Payment Type', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Yii::$app->user->can(PaymentType::VIEW_PAYMENT_TYPE) ?
                            Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('yii', 'View'),
                            ]) : '';
                    },
                    'update' => function ($url, $model, $key) {
                        return Yii::$app->user->can(PaymentType::UPDATE_PAYMENT_TYPE) ?
                            Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                            ]) : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        return Yii::$app->user->can(PaymentType::DELETE_PAYMENT_TYPE) ?
                            Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                'data-method' => 'post',
                            ]) : '';
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
