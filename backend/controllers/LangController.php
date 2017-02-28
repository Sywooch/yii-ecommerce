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
use yii\helpers\Json;

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
                        'actions' => ['trview'],
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
                        'actions' => ['trupdate'],
                        'allow' => true,
                        'roles' => [Lang::UPDATE_LANG]
                    ],                    
                    [
                        'actions' => ['ajax'],
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

        $searchModel = new TranslateSourceMessage();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('trindex', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
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

            $post=Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            if($post["Lang"]["default"] > 0){

            Lang::updateDefaultLang((int)$model->id);

            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Creates a new Lang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTrcreate()
    {
        $model = new TranslateSourceMessage();

        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $model->translates,
            ]);

            $post=Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $getTraslate=Yii::$app->request->post();

            foreach ($getTraslate['TranslateMessage'] as $key => $value) {

                $getmodel=TranslateMessage::find()->where(['and',['id'=>$model->id,'language'=>$key]])->one();
                
            if($getmodel !=null){

                 $getmodel->translation=$value;

             }else{

                $getmodel=new TranslateMessage();
                $getmodel->id=$model->id;
                $getmodel->language=$key;
                $getmodel->translation=$value;
            }

            $getmodel->save();
        }


            return $this->redirect(['trview', 'id' => $model->id]);
        } else {
            return $this->render('trcreate', [
                'model' => $model,
                'dataProvider' => $dataProvider,
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

        $post=Yii::$app->request->post();


        if ($model->load($post) && $model->save()) {

            if($post["Lang"]["default"] > 0){

            Lang::updateDefaultLang((int)$id);

            }

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

            $getmodel->save();
        }


        return $this->redirect(['trview', 'id' => $model->id]);
    } else {
        return $this->render('trupdate', [
            'model' => $model,'dataProvider'=>$dataProvider,
            ]);
    }
}



    /**
     * Change default language
     * @param integer $id
     * @return mixed
     */
    public function actionAjax()
    {

        $post=Yii::$app->request->post();

        if($post['type']==1 && isset($post['id']) && (int)$post['id'] >0){

            echo Json::encode(Lang::updateDefaultLang((int)$post['id']));
            
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
        $model=$this->findModel($id);

        $random=Lang::find()->where(['<>','id',$model->id])->one();

        if($model->url == Lang::getCurrent()->url && $random != null){

            Lang:: setCurrent($random->url);
        }

        if($model->default > 0){

         if($random != null){

             Lang::updateDefaultLang($random->id);

             $model->delete();

         }

     }else{
        
        $model->delete();  
    }

    return $this->redirect(['index']);
}


    /**
     * Deletes an existing Translate mod.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionTrdelete($id)
    {
        $model=new TranslateMessage();

        if($model::find()->where(['id'=>(int)$id])->one() != null){

            if($model->deleteAll(['id'=>(int)$id])){

                $this->findTRModel($id)->delete();
            }else{

            }
        }else{

            $this->findTRModel($id)->delete();
        }
        
        return $this->redirect(['trindex']);
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
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
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
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }


}
