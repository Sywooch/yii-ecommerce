<?php

namespace webdoka\yiiecommerce\controllers;

use webdoka\yiiecommerce\models\Category;
use webdoka\yiiecommerce\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * CatalogController implements the CRUD actions for Order model.
 */
class CatalogController extends Controller
{
    public function actionIndex($category = false)
    {
        $query = Product::find();

        $currentCategory = null;
        if ($category && $currentCategory = Category::find()->where(['slug' => $category])->one()) {
            $query->where(['category_id' => $currentCategory->id]);
        }

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $categories = Category::find()->orderBy(['parent_id' => 'asc'])->all();

        return $this->render('index', compact('currentCategory', 'dataProvider', 'categories'));
    }
}
