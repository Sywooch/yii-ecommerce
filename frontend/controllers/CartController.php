<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\Product;
use yii\data\ArrayDataProvider;

/**
 * Class CartController
 * @package webdoka\yiiecommerce\frontend\controllers
 */
class CartController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionList()
    {
        $sets = Yii::$app->cart->getSets();
        $positions = Yii::$app->cart->getPositions();
        $setsDataProvider = new ArrayDataProvider(['allModels' => $sets]);
        $positionsDataProvider = new ArrayDataProvider(['allModels' => $positions]);

        return $this->render('list', compact('setsDataProvider', 'positionsDataProvider'));
    }

    /**
     * @param $id
     */
    public function actionAdd($id)
    {
        if ($product = Product::findOne($id)) {
            Yii::$app->cart->put($product);
        }
        $this->redirect(['catalog/index']);
    }

    /**
     * @param $id
     */
    public function actionRemove($id)
    {
        if ($product = Product::findOne($id)) {
            Yii::$app->cart->remove($product);
            $this->redirect(['cart/list']);
        }
    }

    /**
     * Removes set by tmpId
     */
    public function actionRemoveSet()
    {
        Yii::$app->cart->removeSetById(Yii::$app->request->get('id'));
        $this->redirect(['cart/list']);
    }
}