<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Delivery;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Deliveries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Delivery::CREATE_DELIVERY)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop_spec', 'Delivery'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
      </div> 
    <div class="box-body">   
        <div class="delivery-index">

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'cost',
            //'storage.name:text:Storage',
            [
                'header' => Yii::t('shop', 'Storage'),
                'attribute' => 'storage.name',
                'format' => 'text',
                'value' => 'storage.name',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
</div>
</div>

