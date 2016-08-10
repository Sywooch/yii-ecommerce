<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\PaymentType;
use yii\base\InvalidParamException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PaymentController
 * @package app\controllers
 */
class PaymentController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * Test action
     */
    public function actionTest()
    {
        return Yii::$app->billing->load('robokassa')->requestPayment(2);
    }

    /**
     * Handles result from payment system.
     * @param $system
     */
    public function actionResult($system)
    {
        if (!$paymentSystem = PaymentType::find()->where(['name' => $system])->one()) {
            throw new InvalidParamException('Invalid $system.');
        }

        Yii::$app->billing->load($system)->handleResult();
    }

    /**
     * Handle success from payment system.
     * @param $system
     * @return \yii\web\Response
     */
    public function actionSuccess($system)
    {
        if (!$paymentSystem = PaymentType::find()->where(['name' => $system])->one()) {
            throw new InvalidParamException('Invalid $system.');
        }

        Yii::$app->billing->load($system)->handleSuccess();

        return $this->redirect(['catalog/index']);
    }

    /**
     * Handle fail from payment system.
     * @param $system
     * @return \yii\web\Response
     */
    public function actionFail($system)
    {
        if (!$paymentSystem = PaymentType::find()->where(['name' => $system])->one()) {
            throw new InvalidParamException('Invalid $system.');
        }

        Yii::$app->billing->load($system)->handleFail();

        return $this->redirect(['catalog/index']);
    }
}
