<?php

namespace webdoka\yiiecommerce\backend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\Cities;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Country::LIST_COUNTRY]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Country::VIEW_COUNTRY]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [Country::UPDATE_COUNTRY]
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(
            [
            'query' => Country::find(),
            ]
        );

        return $this->render(
            'index',
            [
            'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Country model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', compact('model'));
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dataProvider = new ActiveDataProvider([
            'query' => Cities::find()->where(['country_id' => (int)$id]),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'update',
                [
                    'model' => $model, 'dataProvider' => $dataProvider
                ]
            );
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
        $cid = Yii::$app->request->post('cid', 0);
        $type = Yii::$app->request->post('type', -1);
        $q = Yii::$app->request->post('q');

        return $this->renderAjax('_regionform', compact('cid', 'type', 'q'));
    }

    public function actionFormcity()
    {
        $cid = Yii::$app->request->post('cid', 0);
        $region = Yii::$app->request->post('region');
        $type=Yii::$app->request->post('type', -1);
        $q = Yii::$app->request->post('q');

        return $this->renderAjax('_cityform', compact('cid', 'region', 'type', 'q'));
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }
}
