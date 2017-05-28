<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('shop', 'Manufacturer');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Manufacturer'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">
        <div class="discount-index">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    'description:ntext',
                    [
                        'attribute' => 'logo',
                        'value' => function($model) {
                            if(!empty($model->logoFile)) {
                                return Html::img($model->logoImg,['width'=>'150px']);
                            }
                        },
                        'format' => 'html'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
