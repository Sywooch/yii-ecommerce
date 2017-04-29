<?php

namespace webdoka\yiiecommerce\backend\controllers;

use webdoka\yiiecommerce\common\forms\CategoryForm;
use Yii;
use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Feature;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                        'roles' => [Category::LIST_CATEGORY]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Category::VIEW_CATEGORY]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [Category::CREATE_CATEGORY]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [Category::UPDATE_CATEGORY]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Category::DELETE_CATEGORY]
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoryForm();

        $post = Yii::$app->request->post();

        if (isset($post['Feature'])) {
            if (isset($post["CategoryForm"]["relFeatures"])) {
                $mergeFeatures = $post["CategoryForm"]["relFeatures"];
            } else {
                $mergeFeatures = [];
            }

            foreach ($post['Feature'] as $postfeature) {
                    $newfeature = new Feature();
                    $newfeature->name = $postfeature['name'];
                    $newfeature->slug = $postfeature['slug'];
                    $newfeature->save();
                    $mergeFeatures = ArrayHelper::merge($mergeFeatures, [$newfeature->id]);
            }
            $post["CategoryForm"]["relFeatures"] = $mergeFeatures;
        }     

        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = CategoryForm::find()->where(['id' => $id])->one();
        $modelfeatures = new Feature();

        $post = Yii::$app->request->post();

       if (isset($post['Feature'])) {
            if (isset($post["CategoryForm"]["relFeatures"])) {
                $mergeFeatures = $post["CategoryForm"]["relFeatures"];
            } else {
                $mergeFeatures = [];
            }

            foreach ($post['Feature'] as $postfeature) {
                    $newfeature = new Feature();
                    $newfeature->name = $postfeature['name'];
                    $newfeature->slug = $postfeature['slug'];
                    $newfeature->save();
                    $mergeFeatures = ArrayHelper::merge($mergeFeatures, [$newfeature->id]);
            }
            $post["CategoryForm"]["relFeatures"] = $mergeFeatures;
        }

        if (!Yii::$app->request->isPost) {
            CategoryForm::populateRecord($model, ['relFeatures' => $model->features]);
        }

        if ($model->load($post) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelfeatures' => $modelfeatures
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAjax()
    {
        $type = Yii::$app->request->post('type');
        $integerIDs = Yii::$app->request->post('id');
        $integerIDs = implode(',', $integerIDs);
        $ids = array_map('intval', explode(',', $integerIDs));
        //var_dump($ids);exit;
        if ($type == 2) {
            if (CategoryForm::deleteAll(['IN', 'id', $ids])) {
                echo Json::encode('ok');
                exit;
            } else {
                echo Json::encode('Delete failed');
                exit;
            }
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }
}
