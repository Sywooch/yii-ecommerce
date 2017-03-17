<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Set;
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

    

        public function actionOrderpay($id)
        {

            $model = new PayPalForm();

            $order=Order::findOne((int)$id);

            if($order !== null){

            $orderitem = OrderItem::find()->where(['order_id' => $order->id])->all();
            $orderset = OrderSet::find()->where(['order_id' => $order->id])->all();
            }

            $descript = '';

            $count = count($orderitem);

            $i = 1;
            foreach ($orderitem as $data) {

                $product = Product::findOne((int)$data->product_id);
                $descript .= $product->name;
                if($i != $count){
                  $descript .= ', ';  
                }
                $i++;

            }


            $seting['PayPalForm']=[
                'name' => 'Order '. $order->id,
                'summ' => $order->total,
                'currency' => 'USD',
                'description' => $descript,
                'order_id' => $order->id,
                ];


            if ($model->load($seting)) {


                $response = Yii::$app->paypal->request('SetExpressCheckout', $model->Request);


                if (is_array($response) && $response['ACK'] == PayPalForm::STATUS_SUCCESS) {

                    $token = $response['TOKEN'];

                    Yii::$app->paypal->redirect($token);


                }

            }else{
                
            }


        }
    

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


            if (is_array($response) && $response['ACK'] == PayPalForm::STATUS_SUCCESS) {

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

        $model = new PayPalForm();

        $uid = Yii::$app->request->get('uid', -1);
        $order_id = Yii::$app->request->get('order_id', -1);

        if ($uid > 0) {

            $user = User::findIdentity((int)$uid);

        } else {

            $user = '';
        }

        $get = [];

        $get['TOKEN'] = Yii::$app->request->get('token');

        $get['PayerID'] = Yii::$app->request->get('PayerID');

        $payer = Yii::$app->paypal->request('GetExpressCheckoutDetails', $get);


        if (is_array($payer) && $payer['ACK'] == PayPalForm::STATUS_SUCCESS && $payer["CHECKOUTSTATUS"] != PayPalForm::CHECKOUTSTATUS_COMPLETE) {

            $response = Yii::$app->paypal->request('DoExpressCheckoutPayment',
                $payer + $get
            );

            if (is_array($response) && $response['ACK'] == 'Success') {

                if($order_id > 0){

                $model->addPaySuccess($uid,  $order_id, $payer);
                
                }

                Yii::$app->session->setFlash('paypal_success', Yii::t('shop', 'Pay successful.'));


            } else {

                Yii::$app->session->setFlash('paypal_failure', Yii::t('shop', 'No finished pay.').': '. $response["L_LONGMESSAGE0"]);
            }

        } else {

            if ((is_array($payer) && $payer["CHECKOUTSTATUS"] == PayPalForm::CHECKOUTSTATUS_COMPLETE)) {

                if($order_id > 0){

                $model->addPaySuccess($uid,  $order_id, $payer);

                }

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


}
