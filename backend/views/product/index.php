<?php

use yii\helpers\Html;
use yii\grid\GridView;
use webdoka\yiiecommerce\common\models\Product;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Products');
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->user->can(Product::DELETE_PRODUCT)) {

    $ajaxUrl = Url::to(['/admin/shop/product/ajax']);
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
                    $.pjax.reload({container: "#products"});
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


<div class="box box-primary product-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Product::CREATE_PRODUCT)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Product'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">
        <?php Pjax::begin(['id' => 'products']) ?>
        <?=
        GridView::widget(['dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'well'],
            'columns' => [['class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id, 'class' => 'chk'];
                }],


                // ['class' => 'yii\grid\SerialColumn'],
                'id',
                'category_id',
                'name',
                'price',
                //'unit.name:html:Unit',
                ['attribute' => 'unit',
                    'value' => 'unit.name'],
                ['class' => 'yii\grid\ActionColumn',
                    'buttons' => ['view' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Product::VIEW_PRODUCT) ?
                            Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('yii', 'View'),]) : '';
                    },
                        'update' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Product::UPDATE_PRODUCT) ?
                                Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('yii', 'Update'),]) : '';
                        },
                        'delete' => function ($url, $model, $key) {
                            return Yii::$app->user->can(Product::DELETE_PRODUCT) ?
                                Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                    'data-method' => 'post',]) : '';
                        },],],],]);
        ?>
        <?php if (Yii::$app->user->can(Product::DELETE_PRODUCT)) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('shop', 'Delete selected'), '#', ['title' => Yii::t('yii', 'Delete'),
                'class' => 'btn btn-default deleteselected',
                'onclick' => 'return false;',
                'style' => 'float:right;'
                // 'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                //'data-method' => 'post',
            ]) ?>
        <?php } ?>
        <?php Pjax::end() ?>
    </div>
</div>
