<?php

namespace webdoka\yiiecommerce\backend\controllers;

use Yii;
use webdoka\yiiecommerce\common\forms\ProductForm;
use webdoka\yiiecommerce\common\models\Product;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\tree\models\Tree;
use kartik\tree\TreeView;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Product::LIST_PRODUCT]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Product::VIEW_PRODUCT]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [Product::CREATE_PRODUCT]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [Product::UPDATE_PRODUCT]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Product::DELETE_PRODUCT]
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->featuresWithCategories,
        ]);

        $priceDataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->pricesWithValues,
        ]);

        return $this->render('view', compact('model', 'dataProvider', 'priceDataProvider'));
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductForm();
        $model->category_id = Yii::$app->request->get('category_id') ?: null;

        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->featuresWithCategories,
        ]);

        $priceDataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->pricesWithValues,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', compact('model', 'dataProvider', 'priceDataProvider'));
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = ProductForm::find()->where(['id' => $id])->one();
        $model->category_id = Yii::$app->request->get('category_id') ?: $model->category_id;

        if (!Yii::$app->request->isPost)
            $model->populateRelation('relDiscounts', $model->discounts);

        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->featuresWithCategories,
        ]);

        $priceDataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->pricesWithValues,
        ]);
//var_dump(Yii::$app->request->post());exit;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', compact('model', 'dataProvider', 'priceDataProvider'));
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }

}
