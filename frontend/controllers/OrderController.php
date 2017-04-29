<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Account;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\Cities;
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
use webdoka\yiiecommerce\common\models\Profiles;
use app\models\LoginForm;
use app\models\SignupForm;
use yii\helpers\Json;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'fixedVerifyCode' => 'testme',
            ],
        ];
    }


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
    public function actionWelcome()
    {
        $model = new Profiles();
        $modellogin = new LoginForm();
        $modelsignup = new SignupForm();

        if ($modellogin->load(Yii::$app->request->post()) && $modellogin->login()) {
            return $this->renderAjax(
                'welcome',
                [
                    'model' => $model, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                ]
            );
        }

        if ($modelsignup->load(Yii::$app->request->post()) && $modelsignup->signup()) {
            return $this->renderAjax(
                'welcome',
                [
                    'model' => $model, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                ]
            );
        }

        $prf=Yii::$app->request->get("prf", 0);

        if ($prf > 0 && Yii::$app->request->post() == null) {
            $model = Profiles::find()->where(['id'=>(int)$prf, 'status' => Profiles::STATUS_CUSTOMER])->one();
            $modelrec = Profiles::find()->where(['parent_profile'=>(int)$prf, 'status' => Profiles::STATUS_RECIPIENT])->one();


            return $this->render(
                'welcome',
                [
                    'model' => $model, 'modcust' => $model, 'modelrec' => $modelrec, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                ]
            );
        } elseif ($prf > 0 && Yii::$app->request->post() != null && !Yii::$app->user->isGuest) {

            $post = Yii::$app->request->post();

            $from = 0;

            if (isset($post['Profiles']['bothprofiles']) && $post['Profiles']['bothprofiles'] != 1) {
                $i = 0;
                foreach (Profiles::getStatusLists() as $keystatus => $value) {
                    foreach ($post['Profiles'] as $key => $value) {
                        if (isset($value[$keystatus])) {
                            $profile['Profiles'][$key] = $value[$keystatus];
                        }
                    }
                    if ($i == 0) {
                        $model = Profiles::find()->where(['id'=>(int)$prf])->one();

                        $profile['Profiles']['parent_profile'] = null;
                        if ($model->load($profile) && $model->save()) {
                            $from = $model->id;
                        }
                    } else {
                        $model = Profiles::find()->where(['parent_profile'=>(int)$prf])->one();
 
                        $profile['Profiles']['parent_profile'] = $from;
                        if ($model->load($profile) && $model->save()) {
                            return $this->redirect(['create', 'from' => $from]);
                        } else {
                            return $this->render(
                                'welcome',
                                [
                                    'model' => $model, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                                ]
                            );
                        }
                    }

                    $i++;
                }
            } else {
                $i = 0;
                foreach (Profiles::getStatusLists() as $keystatus => $value) {
                    foreach ($post['Profiles'] as $key => $value) {
                        if ($key == 'profile_name' && $i > 0) {
                            $profile['Profiles'][$key] = $value[0] . '-' . Profiles::getStatusLists()[Profiles::STATUS_RECIPIENT];
                        } elseif ($key == 'status' && $i > 0) {
                            $profile['Profiles'][$key] = Profiles::STATUS_RECIPIENT;
                        } else {
                            $profile['Profiles'][$key] = $value[0];
                        }
                    }
                    if ($i == 0) {
                        $model = Profiles::find()->where(['id'=>(int)$prf])->one();
                        $profile['Profiles']['parent_profile'] = null;
                        if ($model->load($profile) && $model->save()) {
                            $from = $model->id;
                        }
                    } else {
                        $model = Profiles::find()->where(['parent_profile'=>(int)$prf])->one();
                        $profile['Profiles']['parent_profile'] = $from;
                        if ($model->load($profile) && $model->save()) {
                            return $this->redirect(['create', 'from' => $from]);
                        } else {
                            return $this->render(
                                'welcome',
                                [
                                    'model' => $model, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                                ]
                            );
                        }
                    }
                    $i++;
                }
            }
        }


        if (Yii::$app->request->post() != null && !Yii::$app->user->isGuest) {
            $post = Yii::$app->request->post();

            $from = 0;

            if (isset($post['Profiles']['bothprofiles']) && $post['Profiles']['bothprofiles'] != 1) {
                $i = 0;
                foreach (Profiles::getStatusLists() as $keystatus => $value) {
                    foreach ($post['Profiles'] as $key => $value) {
                        if (isset($value[$keystatus])) {
                            $profile['Profiles'][$key] = $value[$keystatus];
                        }
                    }
                    if ($i == 0) {
                        $model = new Profiles();
                        $profile['Profiles']['parent_profile'] = null;
                        if ($model->load($profile) && $model->save()) {
                            $from = $model->id;
                        }
                    } else {
                        $model = new Profiles();
                        $profile['Profiles']['parent_profile'] = $from;
                        if ($model->load($profile) && $model->save()) {
                            return $this->redirect(['create', 'from' => $from]);
                        } else {
                            return $this->render(
                                'welcome',
                                [
                                    'model' => $model, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                                ]
                            );
                        }
                    }

                    $i++;
                }
            } else {
                $i = 0;
                foreach (Profiles::getStatusLists() as $keystatus => $value) {
                    foreach ($post['Profiles'] as $key => $value) {
                        if ($key == 'profile_name' && $i > 0) {
                            $profile['Profiles'][$key] = $value[0] . '-' . Profiles::getStatusLists()[Profiles::STATUS_RECIPIENT];
                        } elseif ($key == 'status' && $i > 0) {
                            $profile['Profiles'][$key] = Profiles::STATUS_RECIPIENT;
                        } else {
                            $profile['Profiles'][$key] = $value[0];
                        }
                    }
                    if ($i == 0) {
                        $model = new Profiles();
                        $profile['Profiles']['parent_profile'] = null;
                        if ($model->load($profile) && $model->save()) {
                            $from = $model->id;
                        }
                    } else {
                        $model = new Profiles();
                        $profile['Profiles']['parent_profile'] = $from;
                        if ($model->load($profile) && $model->save()) {
                            return $this->redirect(['create', 'from' => $from]);
                        } else {
                            return $this->render(
                                'welcome',
                                [
                                    'model' => $model, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                                ]
                            );
                        }
                    }
                    $i++;
                }
            }
        } else {
            return $this->render(
                'welcome',
                [
                    'model' => $model, 'modellogin' => $modellogin, 'modelsignup' => $modelsignup
                ]
            );
        }
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

        $get = Yii::$app->request->get();

        $userprofile = Profiles::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['id' => (int)$get['from']])->one();

        if (isset($userprofile->parent->id)) {
            $orderModel = new Order();
            $orderModel->load(Yii::$app->request->post());
            $orderModel->profile_id = (int)$get['from'];
            $orderModel->recipient_id = $userprofile->parent->id;
            $orderModel->total = Yii::$app->cart->getCost();
        } else {
            return $this->redirect(['welcome']);
        }


        if ($country = Country::find()->where('name LIKE "%' . Yii::$app->session->get('country') . '%"')->one()) {
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
            $positions = Yii::$app->cart->getPositions();
            return $this->render('create', compact('model', 'orderModel', 'properties', 'positions'));
        }
    }


    public function actionCountryList($q = null)
    {

        $data = Country::find()->where('name LIKE "%' . $q . '%"')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name'], 'id' => $d['id']];
        }
        echo Json::encode($out);
    }

    public function actionRegionList($cid, $q = null)
    {

        $data = Cities::find()->where('region LIKE "%' . $q . '%"')
            ->groupBy('region')
            ->andWhere(['country_id' => (int)$cid])
            ->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['region']];
        }
        echo Json::encode($out);
    }


    public function actionStateList($cid, $q = null)
    {

        $data = Cities::find()->where('state LIKE "%' . $q . '%"')
            ->groupBy('state')
            ->andWhere(['country_id' => (int)$cid])
            ->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['state']];
        }
        echo Json::encode($out);
    }


    public function actionBigcityList($cid, $q = null)
    {

        $data = Cities::find()->where(['region' => ''])
            ->andWhere(['state' => ''])
            ->andWhere(['country_id' => (int)$cid])
            ->andWhere('city LIKE "%' . $q . '%"')
            ->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['city']];
        }
        echo Json::encode($out);
    }

    public function actionCityList($cid, $q = null, $region = null)
    {

        $data = Cities::find()->where(['country_id' => (int)$cid])
            ->andWhere('region LIKE "%' . $region . '%"')
            ->andWhere('city LIKE "%' . $q . '%"')
            ->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['city']];
        }
        echo Json::encode($out);
    }


    public function actionFormregion()
    {
        $cid = Yii::$app->request->post('cid');

        if ((int)$cid ==0) {
            $cid = Country::getCountryId($cid);
        }
        $type = Yii::$app->request->post('type', -1);
        $q = Yii::$app->request->post('q');

        return $this->renderAjax('_regionform', compact('cid', 'type', 'q'));
    }

    public function actionFormcity()
    {
        $cid = Yii::$app->request->post('cid');
        if ((int)$cid ==0) {
            $cid = Country::getCountryId($cid);
        }
        $region = Yii::$app->request->post('region');
        $type = Yii::$app->request->post('type', -1);
        $q = Yii::$app->request->post('q');

        return $this->renderAjax('_cityform', compact('cid', 'region', 'type', 'q'));
    }
}
