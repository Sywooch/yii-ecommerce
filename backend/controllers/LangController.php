<?php

namespace webdoka\yiiecommerce\backend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\Lang;
use webdoka\yiiecommerce\common\models\TranslateSourceMessage;
use webdoka\yiiecommerce\common\models\TranslateMessage;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LangController implements the CRUD actions for Lang model.
 */
class LangController extends Controller
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
                        'roles' => [Lang::LIST_LANG]
                    ],
                    [
                        'actions' => ['trindex'],
                        'allow' => true,
                        'roles' => [Lang::LIST_LANG]
                    ],                    
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Lang::VIEW_LANG]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [Lang::CREATE_LANG]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [Lang::UPDATE_LANG]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Lang::DELETE_LANG]
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
     * Lists all Lang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Lang::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all TranslateLang models.
     * @return mixed
     */
    public function actionTrindex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TranslateSourceMessage::find(),
        ]);

        return $this->render('trindex', [
            'dataProvider' => $dataProvider,
        ]);
    }    

    /**
     * Displays a single Lang model.
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
     * Displays a single Lang model.
     * @param integer $id
     * @return mixed
     */
    public function actionTrview($id)
    {
        $model=$this->findTRModel($id);
        
        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->translates,
            ]);
        return $this->render('trview', [
            'model' => $model,'dataProvider'=>$dataProvider,
        ]);
    }    

    /**
     * Creates a new Lang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Lang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing TranslateLang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionTrupdate($id)
    {
        $model = $this->findTRModel($id);

        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->translates,
            ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $getTraslate=Yii::$app->request->post();

            foreach ($getTraslate['TranslateMessage'] as $key => $value) {

                $getmodel=TranslateMessage::find()->where(['and',['id'=>(int)$id,'language'=>$key]])->one();
                
                if($getmodel !=null){

                 $getmodel->translation=$value;

             }else{

                $getmodel=new TranslateMessage();
                $getmodel->id=$id;
                $getmodel->language=$key;
                $getmodel->translation=$value;
            }

            if($getmodel->save()){}else{var_dump($getmodel->getErrors()).var_dump($value);exit;}
        }


        return $this->redirect(['trview', 'id' => $model->id]);
    } else {
        return $this->render('trupdate', [
            'model' => $model,'dataProvider'=>$dataProvider,
            ]);
    }
}


    /**
     * Deletes an existing Lang model.
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
     * Finds the Lang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Lang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findTRModel($id)
    {
        if (($model = TranslateSourceMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
