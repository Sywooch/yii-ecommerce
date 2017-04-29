<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Profiles;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-primary profiles-index">
    <div class="box-header with-border">
        <?= Html::a(Yii::t('shop', 'Create Profile') . ' ' . Yii::t('shop', 'Individual'), ['create', 'type' => Profiles::INDIVIDUAL_TYPE], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('shop', 'Create Profile') . ' ' . Yii::t('shop', 'Legal'), ['create', 'type' => Profiles::LEGAL_TYPE], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                //'default_account_id',
                //'type',
                [
                    'attribute' => 'user_id',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->user->username;
                    },
                    // 'filter'=>Profiles::getTypeLists(),
                ],
                [
                    'attribute' => 'type',
                    'format' => 'html',
                    'value' => function ($data) {
                        return Yii::t('shop', ucfirst($data->type));
                    },
                    'filter' => Profiles::getTypeLists(),
                ],
                'profile_name',
                'name',
                // 'last_name',
                // 'ur_name',
                // 'legal_adress',
                // 'country',
                // 'region',
                //  'city',
                // 'individual_adress',
                // 'inn',
                // 'phone',
                //'status',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return Profiles::getStatusLists()[$data->status];
                    },
                    'filter' => Profiles::getStatusLists(),
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

