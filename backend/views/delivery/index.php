<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Delivery;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deliveries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Delivery::CREATE_DELIVERY)) { ?>
            <?= Html::a('Create Delivery', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'cost',
            'storage.name:text:Storage',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
