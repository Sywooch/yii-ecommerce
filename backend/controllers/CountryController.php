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
        $dataProvider = new ActiveDataProvider([
            'query' => Country::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
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
            'query' => Cities::find()->where(['country_id'=>(int)$id]),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,'dataProvider'=>$dataProvider
            ]);
        }
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAjax()
    {

        if(Yii::$app->request->post('action')=='city'){

            $id=Yii::$app->request->post('id');
            $value=Yii::$app->request->post('value');

            $countrys=Cities::find()->select(['city as value', 'city as label','id'])->andWhere(['like','region',$value])->orWhere(['like','state',$value])->asArray()->all();

            Yii::$app->response->format = Response::FORMAT_JSON;
            echo Json::encode($countrys,true);
        }

         if(Yii::$app->request->post('action')=='city2'){

            $id=Yii::$app->request->post('id');
            $value=Yii::$app->request->post('value');

            $countrys=Cities::find()->select(['city as value', 'city as label','id'])->where(['country_id'=>(int)$id])->asArray()->all();

            Yii::$app->response->format = Response::FORMAT_JSON;
            echo Json::encode($countrys,true);
        }       


        if(Yii::$app->request->post('action')=='region'){

            $id=Yii::$app->request->post('id');

            $countrys=Cities::find()->select(['region as value', 'region as label','id'])->groupBy('region')->where(['country_id'=>(int)$id])->asArray()->all();

            Yii::$app->response->format = Response::FORMAT_JSON;
            echo Json::encode($countrys,true);
        }


        if(Yii::$app->request->post('action')=='state'){

            $id=Yii::$app->request->post('id');

            $countrys=Cities::find()->select(['state as value', 'state as label','id'])->groupBy('state')->where(['country_id'=>(int)$id])->asArray()->all();

            Yii::$app->response->format = Response::FORMAT_JSON;
            echo Json::encode($countrys,true);
        }

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
