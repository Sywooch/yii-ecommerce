<?php

namespace webdoka\yiiecommerce\backend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\Profiles;
use webdoka\yiiecommerce\common\models\ProfilesSearch;
use webdoka\yiiecommerce\common\models\Country;
use webdoka\yiiecommerce\common\models\Cities;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use app\models\User;

/**
 * ProfilesController implements the CRUD actions for Profiles model.
 */
class ProfilesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Profiles::LIST_PRODUCT]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Profiles::VIEW_PRODUCT]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [Profiles::CREATE_PRODUCT]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [Profiles::UPDATE_PRODUCT]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Profiles::DELETE_PRODUCT]
                    ]
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
     * Lists all Profiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new Profiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            if (isset($type)) {
                $model->type = $type;
            } else {
                $model->type = Profiles::INDIVIDUAL_TYPE;
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Profiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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

    public function actionUsersList($q = null)
    {

        $data = User::find()->where('username LIKE "%' . $q . '%"')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['username'], 'id' => $d['id']];
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
        $region = Yii::$app->request->post('region');
        $city = Yii::$app->request->post('city');

        return $this->renderAjax('_regionform', compact('cid', 'type', 'region', 'city'));
    }

    public function actionFormcity()
    {
        $cid = Yii::$app->request->post('cid', 0);
        $region = Yii::$app->request->post('region');
        $type = Yii::$app->request->post('type', -1);
        $q = Yii::$app->request->post('city');

        return $this->renderAjax('_cityform', compact('cid', 'region', 'type', 'q'));
    }
}
