<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use webdoka\yiiecommerce\common\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Category::CREATE_CATEGORY)) { ?>
            <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'name',
            'slug',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Category::VIEW_CATEGORY) ?
                            Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('yii', 'View'),
                            ]) : '';
                    },
                    'update' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Category::UPDATE_CATEGORY) ?
                            Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                            ]) : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Category::DELETE_CATEGORY) ?
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
</div>
