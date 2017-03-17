<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Account;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\OrderProperty;
use webdoka\yiiecommerce\common\models\OrderSet;
use webdoka\yiiecommerce\common\models\Property;
use Yii;
use webdoka\yiiecommerce\common\models\OrderItem;
use webdoka\yiiecommerce\common\models\Order;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $profileType = Yii::$app->user->identity->profile->type;

        $properties = Property::find()->where(['profile_type' => $profileType])->indexBy('id')->all();

        $model = new DynamicModel(array_keys($properties));
        foreach ($properties as $property) {
            if ($property->required) {
                $model->addRule($property->id, 'required', ['message' => $property->label . ' cannot be blank.']);
            } else {
                $model->addRule($property->id, 'safe');
            }
        }

        $profileId = Yii::$app->user->identity->profile->id;

        $orderModel = new Order();
        $orderModel->load(Yii::$app->request->post());
        $orderModel->profile_id = $profileId;
        $orderModel->total = Yii::$app->cart->getCost();

        if ($country = Country::find()->where(['id' => Yii::$app->session->get('country')])->one()) {
            $orderModel->country = $country->name;
            if ($country->exists_tax) {
                $orderModel->tax = $country->tax;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $orderModel->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            // Order items
            $orderItems = [];

            $positions = Yii::$app->cart->getPositions();
            foreach ($positions as $position) {
                $orderItem = new OrderItem();
                $orderItem->product_id = $position->getId();
                $orderItem->quantity = $position->getQuantity();
                $orderItem->option_id = $position->getOption_id();

                $orderItems[] = $orderItem;
            }

            // Order sets
            $orderSets = [];
            $orderSetItems = [];

            $sets = Yii::$app->cart->getSets();
            foreach ($sets as $set) {
                $orderSet = new OrderSet();
                $orderSet->set_id = $set->id;

                foreach ($set->setsProducts as $setProduct) {
                    $orderItem = new OrderItem();
                    $orderItem->product_id = $setProduct->product_id;
                    $orderItem->quantity = $setProduct->quantity;

                    $orderSetItems[] = $orderItem;
                }

                $orderSet->populateRelation('orderItems', $orderSetItems);

                $orderSets[] = $orderSet;
            }

            $orderModel->populateRelation('orderItems', $orderItems);
            $orderModel->populateRelation('orderSets', $orderSets);

            // Order properties
            $orderProperties = [];
            foreach ($model->attributes as $propertyId => $propertyValue) {
                $orderProperty = new OrderProperty();
                $orderProperty->property_id = $propertyId;
                $orderProperty->value = $propertyValue;

                $orderProperties[] = $orderProperty;
            }
            $orderModel->populateRelation('ordersProperties', $orderProperties);

            if ($orderModel->save()) {
                $transaction->commit();

                Yii::$app->cart->removeAll();
                Yii::$app->session->setFlash('order_success', Yii::t('shop', 'Order is created successful.'));


                // Create invoice to pay
                if ($account = Account::find()->where(['id' => $orderModel->profile->default_account_id])->one()) {
                    if ($invoiceId = Yii::$app->billing->createInvoice($orderModel->total, $account->id, 'Order #' . $orderModel->id, $orderModel->id)) {
                        // Redirect to pay
                        if (!$paymentSystem = Yii::$app->billing->load($orderModel->paymentType->name)) {
                            throw new InvalidParamException(Yii::t('shop', 'Invalid payment type.'));
                        }

                        return $paymentSystem->requestPayment($invoiceId);
                    } else {
                        Yii::$app->session->setFlash('order_failure', Yii::t('shop', 'Unable to create invoice.'));
                    }
                } else {
                    Yii::$app->session->setFlash('order_failure', Yii::t('shop', 'Unable to get default account.'));
                }

                if($orderModel->paymentType->name == 'PayPal'){

                return $this->redirect(['paypal/orderpay','id'=>$orderModel->id]);

                }

                return $this->redirect(['catalog/index']);
            }

            Yii::$app->session->setFlash('order_failure', Yii::t('shop', 'Order is failed. Check your cart details.'));
            $transaction->rollBack();

            return $this->redirect(['cart/list']);
        } else {
            return $this->render('create', compact('model', 'orderModel', 'properties'));
        }
    }

}
