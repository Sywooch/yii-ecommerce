<?php

namespace webdoka\yiiecommerce\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\OrderItem;
use webdoka\yiiecommerce\common\models\Order;
use yii\web\Controller;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
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
}
