<?php

use yii\widgets\ListView;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$prid = (int)Yii::$app->request->get('id');


$priceDataProvider = new ArrayDataProvider([
    'pagination' => false,
    'allModels' => (new ProductsOptions)->getPricesWithValues($node->id, $prid),
]);

echo $form->field($node, 'description')->textarea(['rows' => 6]);
?>

<?php
if (isset($node->image) && $node->image != '') {

    echo Html::img('@web/uploads/po/' . $node->image, ["style" => "width:80px"]);
}
?>

<?php
echo $form->field($node, 'imagef')->fileInput();
?>
<?php if (ProductsOptions::isOption($node->id) == false): ?>

    <label><?= Yii::t('shop', 'Prices') ?></label>

    <div class="well">

        <?=
        ListView::widget([
            'itemView' => '_price',
            'dataProvider' => $priceDataProvider,
            'summary' => false,
        ]);
        ?>
    </div>

<?php endif; ?>    