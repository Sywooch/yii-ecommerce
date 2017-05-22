<?php

namespace webdoka\yiiecommerce\backend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\ProductsVariants;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

class ProductsVariantsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate($productId, $categoryId)
    {
        $counter = ProductsVariants::find()
            ->where(['product_id' => $productId])
            ->max('vendor_code');
        $model = new ProductsVariants([
            'product_id' => $productId,
            'quantity_stock' => 1,
            'vendor_code' => $counter + 1,
        ]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {  // если получаем AJAX и POST запрос
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model); // выполняем валидацию формы
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'product/update',
                'id'=> $productId,
                'category_id' => $categoryId,
            ]);
        } else {
            return $this->renderAjax('form', ['model' => $model]);
        }
    }

    public function actionUpdate($id, $productId, $categoryId)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'product/update',
                'id'=> $productId,
                'category_id' => $categoryId,
            ]);
        } else {
            return $this->renderAjax('form', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id, $productId, $categoryId)
    {
        $this->findModel($id)->delete();

        return $this->redirect([
            'product/update',
            'id'=> $productId,
            'category_id' => $categoryId,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ProductsVariants::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
