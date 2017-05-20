<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use webdoka\yiiecommerce\common\models\ProductsVariants;

$dataProvider = new ActiveDataProvider([
    'query' => $product->getVariants()
]);

$options = ProductsVariants::getOptions($product->id);

$gridColumns = [
    'id',
    [
        'attribute' => 'vendor_code',
        'value' => function($model) use ($product)  {
            return $product->vendor_code . '.' . $model->vendor_code;
        }
    ],
    'price',
    'quantity_stock',
];
$gridColumns = array_merge($gridColumns, $options);
$gridColumns = array_merge($gridColumns, [
    [
        'class' => yii\grid\ActionColumn::className(),
        'template' => '{update} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                    'title' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                    'onclick' => "variantUpdate({$model->id})"
                ]);
            },
            'delete' => function ($url, $model, $key) use ($product) {
                return Html::a('<span class="glyphicon glyphicon-remove"></span>', Url::to([
                    'products-variants/delete',
                    'id' => $model->id,
                    'productId' => $product->id,
                    'categoryId' => Yii::$app->request->get('category_id')])
                ,[
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => 'Are you sure you want to delete?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);
            },
        ],
    ]
]);


$createVariants = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Variants');
$updateVariants = Yii::t('app', 'Update') . ' ' . Yii::t('shop', 'Variants');
?>

<div class="box box-primary product-index">
    <div class="box-header with-border">
        <?= Html::button($createVariants, ['class' => 'btn btn-success variant-create']) ?>
    </div>
    <div class="box-body">
        <?=GridView::widget([
            'dataProvider'=>$dataProvider,
            'columns' => $gridColumns,
        ]);?>
    </div>
</div>
<?php

Modal::begin([
    'id' => 'modal-variants',
    'header' => 'ad',
    'headerOptions' => ['id'=>'modal-variants_header'],
]);
echo '<div id ="modal-variants_body"></div>';
Modal::end();

$urlCreate = Url::to([
    'products-variants/create',
    'productId' => $product->id,
    'categoryId' => Yii::$app->request->get('category_id'),
]);
$urlUpdate = Url::to([
    'products-variants/update',
    'id' => 'ididid',
    'productId' => $product->id,
    'categoryId' => Yii::$app->request->get('category_id'),
]);

$JS = <<<JS
var modal = $('#modal-variants');
var modalHeader = $('#modal-variants_header');
var modalBody = $('#modal-variants_body');
$('.variant-create').on('click', function() {
    modal.modal();
    modalHeader.empty();
    modalHeader.html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h2>{$createVariants}</h2>');
    $.ajax({
      url: "{$urlCreate}",
      success: function(data){
        modalBody.empty();
        modalBody.html(data);
      }
    });
})
var variantUpdate = function (id) {
    modal.modal();
    modalHeader.empty();
    modalHeader.html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h2>{$updateVariants}</h2>');
    var urlUpdate = "{$urlUpdate}";
    urlUpdate = urlUpdate.replace("ididid",id);
    $.ajax({
      url: urlUpdate,
      success: function(data){
        modalBody.empty();
        modalBody.html(data);
      }
    });
}
JS;
$this->registerJS($JS, $this::POS_END);
?>
