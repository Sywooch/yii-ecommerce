<?php 
use yii\widgets\ListView;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use yii\helpers\Html;


$prid=(int)Yii::$app->request->get('id');


$priceDataProvider = new ArrayDataProvider([
    'pagination' => false,
    'allModels' => (new ProductsOptions)->getPricesWithValues($node->id,$prid),
    ]);

echo $form->field($node, 'description')->textarea(['rows' => 6]);

//echo $form->field($node, 'image')->textInput(['maxlength' => true]);

echo $form->field($node, 'image')->fileInput();


?>
<?php if(ProductsOptions::isOption($node->id)==false): ?>

    <h2>Prices</h2>

    <div class="well">

        <?= ListView::widget([
            'itemView' => '_price',
            'dataProvider' => $priceDataProvider,
            'summary' => false,
            ]); ?>
        </div>

    <?php endif; ?>    