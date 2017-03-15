<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="country-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'exists_tax')->checkbox() ?>

            <?= $form->field($model, 'tax')->textInput() ?>



        <div class="country-index">
        
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'city',
                    'state',
                    'region',
                    //'biggest_city',
                    [
                    'header' => Yii::t('shop', 'Biggest city'),
                    'attribute' => 'biggest_city',
                    'value' => function ($model) {
                        return $model->biggest_city ? (Yii::t('shop', 'State city')) : (Yii::t('shop', 'City'));
                    },
                    'filter'=>true,
                ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '',
                       /* 'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Country::VIEW_COUNTRY) ?
                                    Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                    ]) : '';
                            },
                            'update' => function ($url, $model, $key) {
                                return Yii::$app->user->can(Country::UPDATE_COUNTRY) ?
                                    Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                    ]) : '';
                            },
                        ],*/
                    ],
                ],
            ]);
            ?>
        </div>


        </div>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
