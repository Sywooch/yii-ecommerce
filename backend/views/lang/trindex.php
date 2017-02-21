<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Lang;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Langs');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Lang::CREATE_LANG)) { ?>
            <?= Html::a(Yii::t('app', 'Create Lang'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
      </div>
    <div class="box-body">  

<div class="lang-index">

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'url:url',

            'category',
            'message',
            [
                'attribute' => Yii::t('shop', 'Translations'),
                'format' => 'raw',
                'value' => function ($model) {
                    $trdata='';
                    foreach ($model->translateMessages as $data){
                        $trdata .= '<p>'.$data->language.' - '. $data->translation.'</p>';
                    }

                    return $trdata;
                },
            ],            
            // 'date_update',
            // 'date_create',

                        [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Yii::$app->user->can(Lang::UPDATE_LANG) ?
                            Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/shop/lang/trupdate','id'=>$model->id], [
                                'title' => Yii::t('yii', 'Update'),
                            ]) : '';
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
</div>

</div>