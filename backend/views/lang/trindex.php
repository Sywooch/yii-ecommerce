<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Lang;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Translations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary translation-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Lang::CREATE_LANG)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Translation'), ['trcreate'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">

        <?php
        $cheklang = [];
        $alllang = Lang::find()->all();

        foreach ($alllang as $value) {

            $cheklang[] = $value->url;
        }

        Pjax::begin();
        ?>    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'category',
                'message',
                [
                    'attribute' => Yii::t('shop', 'Translations'),
                    'format' => 'raw',
                    'value' => function ($model) use ($cheklang) {
                        $trdata = '';
                        foreach ($model->translateMessages as $data) {
                            if (in_array($data->language, $cheklang)) {

                                $trdata .= '<p>' . $data->language . ' - ' . $data->translation . '</p>';
                            }
                        }

                        return $trdata;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [

                        'view' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Lang::UPDATE_LANG) ?
                                Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/admin/shop/lang/trview', 'id' => $model->id], [
                                    'title' => Yii::t('yii', 'View'),
                                ]) : '';
                        },
                        'update' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Lang::UPDATE_LANG) ?
                                Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/shop/lang/trupdate', 'id' => $model->id], [
                                    'title' => Yii::t('yii', 'Update'),
                                ]) : '';
                        },
                        'delete' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Lang::UPDATE_LANG) ?
                                Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/shop/lang/trdelete', 'id' => $model->id], [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                    'data-method' => 'post',
                                ]) : '';
                        },
                    ],
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>

</div>