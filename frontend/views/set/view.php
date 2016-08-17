<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\frontend\widgets\CartWidget;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $categories array */

$title = $model->name;
$this->title = Html::encode($title);

$this->params['breadcrumbs'][] = ['label' => 'Sets', 'url' => ['set/index']];
$this->params['breadcrumbs'][] = $this->title;

// VAT included
$vatIncluded = Country::find()->where(['id' => Yii::$app->session->get('country'), 'exists_tax' => 1])->one();

?>

<div id="setList" class="container-fluid">

    <div class="row">
        <div class="col-xs-3">
            <?= CartWidget::widget() ?>
        </div>
        <div class="col-xs-9">
            <h3><?= Html::encode($model->name) ?></h3>

            <hr>

            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

            <?php if (empty($model->setsProducts)) { ?>
                Empty.
            <?php } else { ?>

                <?php foreach ($model->setsProducts as $index => $setsProduct) { ?>
                    <div class="row">
                        <div class="col-md-10">
                            <?= Html::encode($setsProduct->product->name) ?>
                            <?php if ($model->hasErrors('relSetsProducts[' . $index . '][set_id]')) { ?>
                                <div class="has-error">
                            <?php } ?>

                                <?= $form->field($model, 'relSetsProducts[' . $index . '][set_id]')->hiddenInput()->label(false) ?>

                            <?php if ($model->hasErrors('relSetsProducts[' . $index . '][set_id]')) { ?>
                                    <p class="help-block help-block-error"><?= Html::encode($model->getFirstError('relSetsProducts[' . $index . '][set_id]')) ?></p>
                                </div>
                            <?php } ?>

                            <?= $form->field($model, 'relSetsProducts[' . $index . '][product_id]')->hiddenInput()->label(false) ?>
                        </div>
                        <div class="col-md-2">
                            <?php if ($model->hasErrors('relSetsProducts[' . $index . '][quantity]')) { ?>
                                <div class="has-error">
                            <?php } ?>

                                <?= $form->field($model, 'relSetsProducts[' . $index . '][quantity]')->textInput()->label(false) ?>

                            <?php if ($model->hasErrors('relSetsProducts[' . $index . '][quantity]')) { ?>
                                    <p class="help-block help-block-error"><?= Html::encode($model->getFirstError('relSetsProducts[' . $index . '][quantity]')) ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-offset-6 col-md-3">
                        <?= Html::a('Return', ['set/index'], ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::submitButton('Add to cart', ['class' => 'btn btn-success btn-block']) ?>
                    </div>
                </div>

            <?php } ?>

            <?php $form->end() ?>
        </div>
    </div>

</div>
