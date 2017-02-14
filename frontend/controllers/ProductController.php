<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * CatalogController implements the CRUD actions for Order model.
 */
class ProductController extends Controller
{
    public function actionIndex($id)
    {
        $model = Product::findOne(['id'=>(int)$id]);

     /*   $currentCategory = null;
        if ($category && $currentCategory = Category::find()->where(['slug' => $category])->one()) {
            $query->where(['category_id' => $currentCategory->id]);
        }

        $dataProvider = new ActiveDataProvider(['query' => $query]);*/
        $currentCategory = null;
        $categories = Category::find()->orderBy(['parent_id' => 'asc'])->all();

        return $this->render('index', compact('id','model','categories','currentCategory'));
    }
}
