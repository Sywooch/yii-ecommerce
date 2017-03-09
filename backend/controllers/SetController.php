<?php

namespace webdoka\yiiecommerce\backend\controllers;

use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\SetProduct;
use Yii;
use webdoka\yiiecommerce\common\forms\SetForm;
use webdoka\yiiecommerce\common\models\Set;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SetController implements the CRUD actions for Set model.
 */
class SetController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Set models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Set::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Set model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Set model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SetForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $products = Product::find()->orderBy('name')->all();

            return $this->render('create', [
                        'model' => $model,
                        'products' => $products,
            ]);
        }
    }

    /**
     * Updates an existing Set model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        if (!$model = SetForm::find()->where(['id' => $id])->one()) {
            throw new InvalidParamException('Invalid $id.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            if (!Yii::$app->request->isPost) {
                $model->relDiscounts = $model->discounts;
                $model->relSetsProducts = SetProduct::find()->where(['set_id' => $id])->with('product')->all();
            }

            $products = Product::find()->orderBy('name')->all();

            return $this->render('update', [
                        'model' => $model,
                        'products' => $products,
            ]);
        }
    }

    /**
     * Deletes an existing Set model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Set model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Set the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SetForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }

}
