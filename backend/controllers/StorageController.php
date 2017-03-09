<?php

namespace webdoka\yiiecommerce\backend\controllers;

use webdoka\yiiecommerce\common\forms\StorageForm;
use Yii;
use webdoka\yiiecommerce\common\models\Storage;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StorageController implements the CRUD actions for Storage model.
 */
class StorageController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Storage::LIST_STORAGE]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Storage::VIEW_STORAGE]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [Storage::CREATE_STORAGE]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [Storage::UPDATE_STORAGE]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Storage::DELETE_STORAGE]
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
     * Lists all Storage models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Storage::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Storage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Storage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new StorageForm();
        $model->country = Yii::$app->request->get('country');
        $model->city = Yii::$app->request->get('city');
        $model->address = Yii::$app->request->get('address');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $url = Url::to(['create']);
            return $this->render('create', compact('model', 'url'));
        }
    }

    /**
     * Updates an existing Storage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = StorageForm::findOne($id);

        $model->country = $model->location ? $model->location->country : '';
        if (Yii::$app->request->get('country') !== null) {
            $model->country = Yii::$app->request->get('country');
        }

        $model->city = $model->location ? $model->location->city : '';
        if (Yii::$app->request->get('city') !== null) {
            $model->city = Yii::$app->request->get('city');
        }

        $model->address = $model->location ? $model->location->id : '';
        if (Yii::$app->request->get('address') !== null) {
            $model->address = Yii::$app->request->get('address');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $url = Url::to(['update', 'id' => $id]);
            return $this->render('update', compact('model', 'url'));
        }
    }

    /**
     * Deletes an existing Storage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Storage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Storage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Storage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }

}
