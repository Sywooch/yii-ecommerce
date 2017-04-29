<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\Price;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\data\Pagination;

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


        $pageSize = Yii::$app->request->get('per-page', 15);
        $minprice = Yii::$app->request->get('first_price', -1);
        $maxprice = Yii::$app->request->get('last_price', -1);

        $roles = [];
        $roles = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

        $checkpricerole = Price::find()->where(['in', 'auth_item_name', $roles])->all();


        if (!empty($roles) && !empty($checkpricerole)) {
            $query->joinWith('prices');

            $query->andWhere(['in', 'auth_item_name', $roles]);

            $query->groupBy(['product_id']);
        }
        if ($minprice >= 0 && $maxprice > 0) {
            $query->andWhere(['between', 'price', $minprice, $maxprice]);
        }

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $pageSize],
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
            'default' => SORT_DESC,
        ];

        if (!empty($roles)  && !empty($checkpricerole)) {
            $dataProvider->sort->attributes['price'] = [
                'asc' => ['MIN(value)' => SORT_ASC],
                'desc' => ['MIN(value)' => SORT_DESC],
                'default' => SORT_ASC,
            ];
        } else {
            $dataProvider->sort->attributes['price'] = [
                'asc' => ['price' => SORT_ASC],
                'desc' => ['price' => SORT_DESC],
                'default' => SORT_ASC,
            ];
        }

        $categories = Category::find()->orderBy(['parent_id' => 'asc'])->all();

        return $this->render('index', compact('currentCategory', 'dataProvider', 'categories', 'pages', 'query', 'category'));
    }
}
