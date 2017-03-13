<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Lang;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Languages');
$this->params['breadcrumbs'][] = $this->title;

$ajaxUrl = Url::to(["/admin/" . Yii::$app->controller->module->id . '/' . Yii::$app->controller->id . "/ajax"]);

$this->registerJs('
    $(document).on("click","input:radio", function(event, key) {

                    $.ajax({
                type: "POST",
                url: "' . $ajaxUrl . '",
                dataType: "json",
                data: {type: 1, id: $(this).val()},
                success: function (data) {
                    alert("' . Yii::t("shop", "Default language changed") . '");
                }
            });


   }); 
   ');
?>

<div class="box box-primary lang-index">
    <div class="box-header with-border">
        <?php if (Yii::$app->user->can(Lang::CREATE_LANG)) { ?>
            <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Language'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <div class="box-body">

        <?php Pjax::begin(); ?>    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'url',
                'local',
                'name',
                [
                    'header' => 'default',
                    'format' => 'raw',
                    'value' => function ($data) {

                        return Html::radio("default", $data->default, array("value" => $data->id));
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>

</div>