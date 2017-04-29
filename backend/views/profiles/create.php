<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Profiles */

$this->title = Yii::t('shop', 'Create Profiles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model' => $model]) ?>

