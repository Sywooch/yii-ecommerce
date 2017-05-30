<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('shop', 'Handbook Vat');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop','Handbook Vat'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">
        <div class="discount-index">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'percent',
                    [
                        'attribute' => 'isDefault',
                        'value' => function ($model) {
                            return $model->isDefault ? 'Да' : 'Нет';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                if($model->id == 1) {
                                    return false;
                                }

                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-delete'),
                                    'data' => [
                                        'confirm' => 'Are you absolutely sure ?',
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
