<?php

namespace webdoka\yiiecommerce\backend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\Location;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use webdoka\yiiecommerce\common\models\LocationsPakDeliveries;
use webdoka\yiiecommerce\common\models\Storage;
use webdoka\yiiecommerce\common\models\Delivery;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LocationController implements the CRUD actions for Location model.
 */
class LocationController extends Controller
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
                'roles' => [Location::LIST_LOCATION]
            ],
            [
                'actions' => ['view'],
                'allow' => true,
                'roles' => [Location::VIEW_LOCATION]
            ],
            [
                'actions' => ['create'],
                'allow' => true,
                'roles' => [Location::CREATE_LOCATION]
            ],
            [
                'actions' => ['update'],
                'allow' => true,
                'roles' => [Location::UPDATE_LOCATION]
            ],
            [
                'actions' => ['delete'],
                'allow' => true,
                'roles' => [Location::DELETE_LOCATION]
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
     * Lists all Location models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider(['query' => Location::find()]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single Location model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Location();
        $pakmodel = new DeliveriesLocationsPak();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model, 'pakmodel' => $pakmodel]);
        }
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreated()
    {
        $model = new Location();
        $pakmodel = new DeliveriesLocationsPak();
        $pakrelation = new LocationsPakDeliveries();

        $locationpost = Yii::$app->request->post();

        if (isset($locationpost['Location']['bigcity']) && $locationpost['Location']['bigcity'] != "") {
            $locationpost['Location']['city'] = $locationpost['Location']['bigcity'];
        }

        if ($model->load($locationpost) && $model->save()) {
            if ($post = Yii::$app->request->post('DeliveriesLocationsPak')) {
                if (isset($post['name'][1]) && $post['name'][1] != "") {
                    $pakmodel->name = $post['name'][1];
                    $pakmodel->save();

                    $pakrelation->pak_id = $pakmodel->id;
                    $pakrelation->locations_id = $model->id;
                    $pakrelation->save();
                } elseif (isset($post['name'][0])) {
                    $pakrelation->pak_id = (int)$post['name'][0];
                    $pakrelation->locations_id = $model->id;
                    $pakrelation->save();
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('created', ['model' => $model, 'pakmodel' => $pakmodel]);
        }
    }


    /**
     * Updates an existing Location model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $pakrelation = LocationsPakDeliveries::find()->where(['locations_id'=>$id])->one();

        $pakmodel = new DeliveriesLocationsPak();

        $locationpost = Yii::$app->request->post();

        if (isset($locationpost['Location']['bigcity']) && $locationpost['Location']['bigcity'] != "") {
            $locationpost['Location']['city'] = $locationpost['Location']['bigcity'];
        }

        if ($model->load($locationpost) && $model->save()) {
            if ($post = Yii::$app->request->post('DeliveriesLocationsPak')) {
                if (isset($post['name'][1]) && $post['name'][1] != "") {
                    $pakmodel->name = $post['name'][1];
                    $pakmodel->save();

                    if (isset($pakrelation->pak_id)) {
                        $pakexissts = LocationsPakDeliveries::find()
                        ->where(['pak_id'=>$pakrelation->pak_id])
                        ->andWhere(['locations_id'=>$model->id])
                        ->one();
                    } else {
                        $pakexissts=null;
                    }
                    if ($pakexissts == null) {
                        $pakrelation = new LocationsPakDeliveries();
                        $pakrelation->pak_id = $pakmodel->id;
                        $pakrelation->locations_id = $model->id;
                        $pakrelation->save();
                    } elseif ($pakexissts->pak_id != $pakmodel->id) {
                        $pakexissts->pak_id = $pakmodel->id;
                        $pakexissts->save();
                    }
                } elseif (isset($post['name'][0])) {
                    if (isset($pakrelation->pak_id)) {
                        $pakexissts = LocationsPakDeliveries::find()
                        ->where(['pak_id'=>$pakrelation->pak_id])
                        ->andWhere(['locations_id'=>$model->id])
                        ->one();
                    } else {
                        $pakexissts=null;
                    }
                    if ($pakexissts === null) {
                        $pakrelation = new LocationsPakDeliveries();
                        $pakrelation->pak_id = (int)$post['name'][0];
                        $pakrelation->locations_id = $model->id;
                        $pakrelation->save();
                    } elseif ($pakexissts->pak_id != (int)$post['name'][0]) {
                        $pakexissts->pak_id = (int)$post['name'][0];
                        $pakexissts->save();
                    }
                }
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', ['model' => $model, 'pakmodel' => $pakmodel, 'pakrelation' => $pakrelation]);
        }
    }

    /**
     * Deletes an existing Location model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {


        $model = $this->findModel($id);

        if ($model->type == Location::TYPE_DELIVERY) {
            $pakrelation = LocationsPakDeliveries::find()->where(['locations_id' => $id])->one();

            $pak = DeliveriesLocationsPak::find()->where(['id' => $pakrelation->pak_id]);
            $pakrelation->delete();
            if ($pak->count() <= 1) {
                $pak->one()->delete();
            }
        }

        if ($storage=Storage::find()->where(['location_id' => $id])->one()) {
            if ($delivery=Delivery::find()->where(['storage_id' => $storage->id])->one()) {
                $delivery->delete();
            }
                   $storage->delete();
        }
        $this->findModel($id)->delete();


        return $this->redirect(['index']);
    }

    /**
     * Finds the Location model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Location the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Location::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }
}
