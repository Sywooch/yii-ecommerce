<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lang */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('shop', 'Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=

$this->render('_form', [
    'model' => $model,
])
?>

