<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\Set;
use webdoka\yiiecommerce\common\models\SetProduct;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use webdoka\yiiecommerce\common\forms\SetConfigForm;

/**
 * SetController implements the CRUD actions for Order model.
 */
class SetController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = SetConfigForm::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $categories = Category::find()->orderBy(['parent_id' => 'asc'])->all();

        return $this->render('index', compact('dataProvider', 'categories'));
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        if (!$model = SetConfigForm::find()->where(['id' => $id])->one()) {
            throw new InvalidParamException(Yii::t('shop','Invalid'). ' $id.');
        }

        if (!Yii::$app->request->isPost) {
            $model->relSetsProducts = $model->setsProducts;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $set = null;
            $setsProducts = [];

            foreach ($model->relSetsProducts as $i => $relSetProduct) {
                if (!$set) {
                    $set = Set::find()->where(['id' => $relSetProduct['set_id']])->one();
                }
                if ($product = Product::find()->where(['id' => $relSetProduct['product_id']])->one()) {
                    $setProduct = new SetProduct();
                    $setProduct->set_id = $relSetProduct['set_id'];
                    $setProduct->product_id = $relSetProduct['product_id'];
                    $setProduct->quantity = $relSetProduct['quantity'];

                    $setsProducts[] = $setProduct;
                }
            }

            if ($set) {
                $set->populateRelation('setsProducts', $setsProducts);
                Yii::$app->cart->putSet($set);
            }

            return $this->redirect(['set/index']);
        }

        return $this->render('view', compact('model'));
    }
}
