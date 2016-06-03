<?php

namespace webdoka\yiiecommerce\controllers;

use webdoka\yiiecommerce\models\Product;

class CartController extends \yii\web\Controller
{
    public function actionAdd($id)
    {
        if ($product = Product::findOne($id)) {
            \Yii::$app->cart->put($product);
        }
        return $this->goBack();
    }

    public function actionRemove($id)
    {
        if ($product = Product::findOne($id)) {
            \Yii::$app->cart->remove($product);
            $this->redirect(['catalog/index']);
        }
    }
}