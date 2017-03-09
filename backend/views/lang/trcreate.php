<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Translations'), 'url' => ['trindex']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=

$this->render('_trform', [
    'model' => $model,
    'dataProvider' => $dataProvider,
])
?>

