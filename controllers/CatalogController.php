<?php

namespace webdoka\yiiecommerce\controllers;

use webdoka\yiiecommerce\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * CatalogController implements the CRUD actions for Order model.
 */
class CatalogController extends Controller
{
    public function actionIndex()
    {
        $category = null;
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', compact('category', 'dataProvider'));
    }
}
