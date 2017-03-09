<?php

namespace webdoka\yiiecommerce\backend\controllers;

use webdoka\yiiecommerce\common\models\OrderHistory;
use webdoka\yiiecommerce\common\models\OrderItem;
use webdoka\yiiecommerce\common\models\OrderSet;
use webdoka\yiiecommerce\common\models\OrderTransaction;
use Yii;
use webdoka\yiiecommerce\common\models\Order;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'status'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Order::LIST_ORDER]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Order::VIEW_ORDER]
                    ],
                    [
                        'actions' => ['status'],
                        'allow' => true,
                        'roles' => [Order::UPDATE_ORDER]
                    ],
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        $pageSize = 10;

        $contactDataProvider = new ArrayDataProvider();
        $contactDataProvider->allModels = $model->ordersProperties;
        $contactDataProvider->pagination->pageSize = $pageSize;

        $productDataProvider = new ActiveDataProvider();
        $productDataProvider->query = OrderItem::find()->where(['order_id' => $model->id]);
        $productDataProvider->pagination->pageSize = $pageSize;

        $setDataProvider = new ActiveDataProvider();
        $setDataProvider->query = OrderSet::find()->where(['order_id' => $model->id]);
        $setDataProvider->pagination->pageSize = $pageSize;

        $transactionDataProvider = new ActiveDataProvider();
        $transactionDataProvider->query = OrderTransaction::find()->where(['order_id' => $model->id]);
        $transactionDataProvider->pagination->pageSize = $pageSize;

        $historyDataProvider = new ActiveDataProvider();
        $historyDataProvider->query = OrderHistory::find()->where(['order_id' => $model->id]);
        $historyDataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
        $historyDataProvider->pagination->pageSize = $pageSize;

        return $this->render('view', compact(
                                'model', 'contactDataProvider', 'productDataProvider', 'setDataProvider', 'transactionDataProvider', 'historyDataProvider'
        ));
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStatus($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }

}
