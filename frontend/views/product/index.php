<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\frontend\widgets\CartWidget;

/* @var $this yii\web\View */
/* @var $currentCategory webdoka\yiiecommerce\common\models\Category */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $categories array */

$title = Yii::t('shop', 'Shop');
$this->title = Html::encode($title);

if ($currentCategory) {
    $this->params['breadcrumbs'][] = [
        'label' => $this->title,
        'url' => ['catalog/index']
    ];
    $this->params['breadcrumbs'][] = $currentCategory->name;
} else {
    $this->params['breadcrumbs'][] = $this->title;
}


// VAT included
$vatIncluded = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one();
?>

<div class="row">

    <?php if (Yii::$app->session->hasFlash('order_success')) { ?>
        <?php if (is_array(Yii::$app->session->getFlash('order_success'))) { ?>
            <?php foreach (Yii::$app->session->getFlash('order_success') as $message) { ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <strong><?= Html::encode($message) ?></strong>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <strong><?= Html::encode(Yii::$app->session->getFlash('order_success')) ?></strong>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if (Yii::$app->session->hasFlash('order_failure')) { ?>
        <?php if (is_array(Yii::$app->session->getFlash('order_failure'))) { ?>
            <?php foreach (Yii::$app->session->getFlash('order_failure') as $message) { ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <strong><?= Html::encode($message) ?></strong>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <strong><?= Html::encode(Yii::$app->session->getFlash('order_failure')) ?></strong>
            </div>
        <?php } ?>
    <?php } ?>


    <?= $this->render('_product', compact('model', 'vatIncluded')); ?>
    <?= $this->render('_details', compact('model', 'vatIncluded')); ?>

</div>
