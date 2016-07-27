<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\forms\OrderForm;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\OrderProperty;
use webdoka\yiiecommerce\common\models\Property;
use Yii;
use webdoka\yiiecommerce\common\models\OrderItem;
use webdoka\yiiecommerce\common\models\Order;
use yii\base\DynamicModel;
use yii\base\Exception;
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
        $properties = Property::find()->indexBy('id')->all();

        $model = new DynamicModel(array_keys($properties));
        foreach ($properties as $property) {
            if ($property->required) {
                $model->addRule($property->id, 'required', ['message' => $property->label . ' cannot be blank.']);
            } else {
                $model->addRule($property->id, 'safe');
            }
        }

        $orderModel = new Order();
        $orderModel->load(Yii::$app->request->post());
        $orderModel->user_id = Yii::$app->user->id;
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

                $orderItems[] = $orderItem;
            }
            $orderModel->populateRelation('orderItems', $orderItems);

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
                Yii::$app->session->setFlash('order_success', 'Order is created successful, check your email for details.');

                // Send email

                return $this->redirect(['catalog/index']);
            }

            Yii::$app->session->setFlash('order_failure', 'Order is failed. Check your cart details.');
            $transaction->rollBack();

            return $this->redirect(['cart/list']);
        } else {
            return $this->render('create', compact('model', 'orderModel', 'properties'));
        }
    }
}
