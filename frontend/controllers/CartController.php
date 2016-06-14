<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Product;
use yii\data\ArrayDataProvider;


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