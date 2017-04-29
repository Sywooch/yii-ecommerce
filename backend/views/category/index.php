<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use webdoka\yiiecommerce\common\models\Category;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->user->can(Category::DELETE_CATEGORY)) {

    $ajaxUrl = Url::to(['/admin/shop/category/ajax']);
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
                    $.pjax.reload({container: "#categories"});
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

<div class="box box-primary">
    <div class="box-header with-border">

        <?php if (Yii::$app->user->can(Category::CREATE_CATEGORY)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Category'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">
        <div class="category-index">
            <?php Pjax::begin(['id' => 'categories']); ?>
            <?=
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
                    //['class' => 'yii\grid\SerialColumn'],
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
            ]);
            ?>
            <?php if (Yii::$app->user->can(Category::DELETE_CATEGORY)) { ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('shop', 'Delete selected'), '#', [
                    'title' => Yii::t('yii', 'Delete'),
                    'class' => 'btn btn-default deleteselected',
                    'onclick' => 'return false;',
                    'style' => 'float:right'
                    // 'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                    //'data-method' => 'post',
                ]) ?>
            <?php } ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
