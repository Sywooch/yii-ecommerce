<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Category;
use webdoka\yiiecommerce\common\models\Product;
use webdoka\yiiecommerce\common\models\OrderHistory;
use webdoka\yiiecommerce\common\models\OrderItem;
use webdoka\yiiecommerce\common\models\OrderSet;
use webdoka\yiiecommerce\common\models\OrderTransaction;
use webdoka\yiiecommerce\common\models\Order;
use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\User;
use webdoka\yiiecommerce\common\forms\PayPalForm;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class PaypalController extends Controller
{


    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new PayPalForm();

        return $this->render('index', compact('message', 'model'));

    }



    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    /*

        public function actionOrderpay($id)
        {

           //var_dump($id); exit;

            $model = new PayPalForm();

            $order=Order::findOne((int)$id);

            if($order !== null){

            $orderitem = OrderItem::find()->where(['order_id' => $order->id])->all();
            $orderset = OrderSet::find()->where(['order_id' => $order->id]);
            }

            $descript = '';

            $quantity = 0;

            foreach ($orderitem as $data) {

                $product=Product::findOne((int)$data->product_id);
                $descript .= $product->name;
                $quantity = $quantity + $data->quantity;

            }

            if($quantity == 0){
                $quantity = 1;
            }

            $set['PayPalForm']=[
                'name' => 'Order#:'. $order->id,
                'summ' => $order->total,
                'currency' => 'USD',
                'description' => $descript,
                'quantity' => $quantity,
                'order_id' => $order->id,
                ];


            if ($model->load($set)) {


                $response = Yii::$app->paypal->request('SetExpressCheckout', $model->Request);


                if (is_array($response) && $response['ACK'] == 'Success') {

                    $token = $response['TOKEN'];

                    Yii::$app->paypal->redirect($token);


                }else{
                  var_dump($response);
                }

            }else{
                echo 1;
            }


        }
    */

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPay()
    {

        $model = new PayPalForm();


        if ($model->load(Yii::$app->request->post())) {


            $response = Yii::$app->paypal->request('SetExpressCheckout', $model->Request);


            if (is_array($response) && $response['ACK'] == 'Success') {

                $token = $response['TOKEN'];

                Yii::$app->paypal->redirect($token);


            }

        }


    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSuccess()
    {


        $uid = Yii::$app->request->get('uid', -1);

        if ($uid > 0) {

            $user = User::findIdentity((int)$uid);

        } else {

            $user = '';
        }

        $get = [];

        $get['TOKEN'] = Yii::$app->request->get('token');

        $get['PayerID'] = Yii::$app->request->get('PayerID');

        $payer = Yii::$app->paypal->request('GetExpressCheckoutDetails', $get);


        if (is_array($payer) && $payer['ACK'] == 'Success' && $payer["CHECKOUTSTATUS"] != 'PaymentActionCompleted') {

            $response = Yii::$app->paypal->request('DoExpressCheckoutPayment',
                $payer + $get
            );

            if (is_array($response) && $response['ACK'] == 'Success') {

                Yii::$app->session->setFlash('paypal_success', Yii::t('shop', 'Pay successful.'));


            } else {

                Yii::$app->session->setFlash('paypal_failure', Yii::t('shop', 'No finished pay.'));
            }

        } else {

            if ((is_array($payer) && $payer["CHECKOUTSTATUS"] == 'PaymentActionCompleted')) {

                Yii::$app->session->setFlash('paypal_success', Yii::t('shop', 'Already paid.'));

            } else {

                Yii::$app->session->setFlash('paypal_failure', Yii::t('shop', 'Pay not found.'));
            }
        }


        return $this->render('success', compact('payer', 'user'));

    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCancelled()
    {

        $uid = Yii::$app->request->get('uid', -1);

        if ($uid > 0) {

            $user = User::findIdentity((int)$uid);

        } else {

            $user = '';
        }

        $get = [];

        $get['TOKEN'] = Yii::$app->request->get('token');

        $payer = Yii::$app->paypal->request('GetExpressCheckoutDetails', $get);

        Yii::$app->session->setFlash('paypal_failure', Yii::t('shop', 'Pay cancelled.'));

        return $this->render('cancell', compact('payer', 'user'));

    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIpn()
    {

        return $this->render('ipn', compact('model', 'orderModel', 'properties'));

    }


}
