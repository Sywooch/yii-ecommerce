<?php

namespace webdoka\yiiecommerce\controllers;

use webdoka\yiiecommerce\models\Product;
use yii\data\ArrayDataProvider;
use yii\db\Transaction;

class CartController extends \yii\web\Controller
{
    public function actionList()
    {
        $positions = \Yii::$app->cart->getPositions();
        $dataProvider = new ArrayDataProvider(['allModels' => $positions]);

        return $this->render('list', compact('dataProvider'));
    }

    public function actionAdd($id)
    {
        if ($product = Product::findOne($id)) {
            \Yii::$app->cart->put($product);
        }
        $this->redirect(['catalog/index']);
    }

    public function actionRemove($id)
    {
        if ($product = Product::findOne($id)) {
            \Yii::$app->cart->remove($product);
            $this->redirect(['cart/list']);
        }
    }
}