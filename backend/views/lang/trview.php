<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use webdoka\yiiecommerce\common\models\Lang;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */

$this->title = $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
       <?php if (Yii::$app->user->can(Lang::UPDATE_LANG)) { ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if (Yii::$app->user->can(Lang::DELETE_LANG)) { ?>        
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                ],
                ]) ?>
                <?php } ?>
            </div>
            <div class="box-body">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                    'id',
                    'category',
                    'message',

                    ],
                    ]) ?>

                </div>

                <div class="well">
                  

                    <?= ListView::widget([
                        'itemView' => '_trview',
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                        ]); ?>

                
                    </div>

            </div>
