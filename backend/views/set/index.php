<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Set;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Sets');
$this->params['breadcrumbs'][] = $this->title;


if (Yii::$app->user->can(Set::DELETE_SET)) {
    $ajaxUrl = Url::to(['/admin/shop/set/ajax']);
    $this->registerJs('

 $(document).on("click",".deleteselected",function () {
 
        var arr = [];
        $("table tbody input:checkbox:checked").each(function () {
            arr.push(parseInt($(this).val()));
        });
        if (arr.length != 0) {
          var confirmdelete = confirm("' . Yii::t('shop', 'Are you sure to delete this item?') . '");
            if(confirmdelete !== false){ 
            $.ajax({
                type: "POST",
                url: "' . $ajaxUrl . '",
                dataType: "json",
                data: {type: 2, id: arr},
                success: function (data) {
                    $.pjax.reload({container: "#sets"});
                    alert("' . Yii::t('shop', 'Delete successful') . '");
                }
            });
        }
    }else{
        alert("' . Yii::t('shop', 'Nothing selected') . '");
    }
        });');
}


?>
<div class="box box-primary set-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Set::CREATE_SET)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Set'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">
        <?php Pjax::begin(['id' => 'sets']); ?>    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'well'],
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->id, 'class' => 'chk'];
                    }
                ],
                // ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Set::VIEW_SET) ?
                                Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('yii', 'View'),
                                ]) : '';
                        },
                        'update' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Set::UPDATE_SET) ?
                                Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                ]) : '';
                        },
                        'delete' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Set::DELETE_SET) ?
                                Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
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
        <?php if (Yii::$app->user->can(Set::DELETE_SET)) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('shop', 'Delete selected'), '#', [
                'title' => Yii::t('yii', 'Delete'),
                'class' => 'btn btn-default deleteselected',
                'onclick' => 'return false;',
                'style' => 'float:right;'
                // 'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                //'data-method' => 'post',
            ]) ?>
        <?php } ?>

        <?php Pjax::end(); ?>
    </div>
</div>
