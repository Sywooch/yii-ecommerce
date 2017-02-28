<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \webdoka\yiiecommerce\common\models\Country;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Country');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
   <div class="box-body"> 
    <div class="country-index">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'well'],
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'abbr',
            'exists_tax',
            'tax',

            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}',
            'buttons' => [
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
            ],
            ],
            ],
            ]); ?>
        </div>
    </div>

</div>
