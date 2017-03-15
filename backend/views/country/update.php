<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \webdoka\yiiecommerce\common\models\Country */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('shop', 'Country') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<?=

$this->render('_form', [
    'model' => $model,'dataProvider'=>$dataProvider
])
?>

