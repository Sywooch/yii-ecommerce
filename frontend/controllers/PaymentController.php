<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * PaymentController.
 */
class PaymentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['result', 'success', 'fail'],
                'rules' => [
                    [
                        'actions' => ['success', 'fail'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actionResult()
    {

    }

    public function actionSuccess()
    {

    }

    public function actionFail()
    {

    }
}
