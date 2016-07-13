<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \webdoka\yiiecommerce\common\models\Account;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can(Account::CREATE_ACCOUNT)) { ?>
            <?= Html::a('Create Account', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summaryOptions' => ['class' => 'well'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'balance',
            'currency.symbol',
            'user.username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
