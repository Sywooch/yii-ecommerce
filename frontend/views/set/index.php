<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\frontend\widgets\CartWidget;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $categories array */

$title = Yii::t('shop','Sets');
$this->title = Html::encode($title);

$this->params['breadcrumbs'][] = ['label' => Yii::t('shop','Shop'), 'url' => ['catalog/index']];
$this->params['breadcrumbs'][] = $this->title;

// VAT included
$vatIncluded = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one();

?>

<div id="setList" class="container-fluid">

    <div class="row">
        <div class="col-xs-3">
            <?= CartWidget::widget() ?>
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="active"><?= Html::a(Yii::t('shop','Sets'), ['set/index']) ?></li>
                <hr>
                <li role="presentation"><?= Html::a(Yii::t('shop','All'), ['catalog/index']) ?></li>
                <?php foreach ($categories as $category) { ?>
                    <li role="presentation"><?= Html::a($category->name, ['catalog/' . $category->slug]) ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-xs-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'summaryOptions' => ['class' => 'well well-sm'],
                'itemView' => '_set',
                'viewParams' => compact('vatIncluded')
            ]) ?>
        </div>
    </div>

</div>