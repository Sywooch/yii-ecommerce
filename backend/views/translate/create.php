<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TranslateMessage */

$this->title = Yii::t('app', 'Create Translate Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translate Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translate-message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
