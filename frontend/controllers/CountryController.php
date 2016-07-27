<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use webdoka\yiiecommerce\common\models\Country;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;


class CountryController extends \yii\web\Controller
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
                    'change' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Changes country in session
     */
    public function actionChange()
    {
        if ($country = Country::findOne(Yii::$app->request->post('country'))) {
            Yii::$app->session->set('country', $country->id);
        }
    }
}