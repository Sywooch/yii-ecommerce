<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Feature */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Feature');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Features'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=

$this->render('_form', [
    'model' => $model,
])
?>

