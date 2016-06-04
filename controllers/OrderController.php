<?php

namespace webdoka\yiiecommerce\controllers;

use webdoka\yiiecommerce\models\OrderItem;
use Yii;
use webdoka\yiiecommerce\models\Order;
use yii\data\ActiveDataProvider;
use yii\db\Transaction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $transaction = Yii::$app->db->beginTransaction();
            $positions = Yii::$app->cart->getPositions();

            if ($model->save() && !empty($positions)) {

                $allOrderItemsSaved = true;

                foreach ($positions as $position) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $model->id;
                    $orderItem->product_id = $position->getId();
                    $orderItem->quantity = $position->getQuantity();
                    $allOrderItemsSaved &= $orderItem->save();
                }

                if ($allOrderItemsSaved) {
                    $transaction->commit();
                    Yii::$app->cart->removeAll();
                    Yii::$app->session->setFlash('order_success', 'Order is created successful, check your email for details.');

                    // Send email

                    return $this->redirect(['catalog/index']);
                }
            }

            $transaction->rollBack();
            Yii::$app->session->setFlash('order_failure', 'Order is failed. Check your cart details.');

            return $this->redirect(['cart/list']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
