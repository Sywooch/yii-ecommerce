<?php

namespace webdoka\yiiecommerce\backend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\ProductsOptions;
use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;
use webdoka\yiiecommerce\common\models\Price;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\View;
use kartik\tree\models\Tree;
use kartik\tree\TreeView;
use yii\base\ErrorException;
use yii\base\Event;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\console\Application;
use yii\db\Exception as DbException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ProductsOptionsController implements the CRUD actions for ProductsOptions model.
 */
class ProductsOptionsController extends Controller
{
    
    /**
     * @var array the list of keys in $_POST which must be cast as boolean
     */
    public static $boolKeys = [
        'isAdmin',
        'softDelete',
        'showFormButtons',
        'showIDAttribute',
        'multiple',
        'treeNodeModify',
        'allowNewRoots',
    ];

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
                        'roles' => [ProductsOptions::LIST_POPTIONS]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [ProductsOptions::VIEW_POPTIONS]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [ProductsOptions::CREATE_POPTIONS]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [ProductsOptions::UPDATE_POPTIONS]
                    ],
                    [
                        'actions' => ['save'],
                        'allow' => true,
                        'roles' => [ProductsOptions::UPDATE_POPTIONS]
                    ], 
                    [
                        'actions' => ['ajax'],
                        'allow' => true,
                        'roles' => [ProductsOptions::UPDATE_POPTIONS]
                    ],                     
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [ProductsOptions::DELETE_POPTIONS]
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
     * Lists all ProductsOptions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductsOptions::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductsOptions model.
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
     * Creates a new ProductsOptions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsOptions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductsOptions model.
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

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }    


    /**
     * Ajax options-price-product saver
     */
    public function actionAjax()
    {
        $post = Yii::$app->request->post();
        $data = static::getPostData();

        $prices = Price::find()->all();

        if(isset($data["optid"])){

            foreach ($data["optid"] as $value) {

                foreach ($prices as $pricedata) {

                $getoptions=ProductsOptionsPrices::find()->where(['=',"product_id",(int)$data["prodid"]])->andWhere(['=', 'product_options_id', (int)$value])->andWhere(['=', 'price_id', $pricedata->id])->one();
#Add to list
                if($getoptions == null){
                    $addopt=new ProductsOptionsPrices();
                    $addopt->product_id=(int)$data["prodid"];
                    $addopt->product_options_id=(int)$value;
                    $addopt->price_id=$pricedata->id;
                    $addopt->value=0;
                    $addopt->save();
                    }

                }

            }

                $condition = ['=',"product_id",(int)$data["prodid"]];
                ProductsOptionsPrices::updateAll(['status'=>0], $condition);

                $condition = ['and',
                    ['=',"product_id",(int)$data["prodid"]],
                    ['in', 'product_options_id', $data["optid"]],
                ];
                ProductsOptionsPrices::updateAll(['status'=>1], $condition);

        }else{
                $condition = ['and',
                    ['=',"product_id",(int)$data["prodid"]],
                    ['=', 'status', 1],
                ];

                ProductsOptionsPrices::updateAll(['status'=>0], $condition);
        }

    }


    /**
     * Saves a node once form is submitted
     */
    public function actionSave()
    {
        $post = Yii::$app->request->post();
        static::checkValidRequest(false, !isset($post['treeNodeModify']));
        $treeNodeModify = $parentKey = $currUrl = $treeSaveHash = null;
        $modelClass = '\kartik\tree\models\Tree';
        $data = static::getPostData();
        extract($data);
        $module = TreeView::module();
        $keyAttr = $module->dataStructure['keyAttribute'];
        /**
         * @var Tree $modelClass
         * @var Tree $node
         * @var Tree $parent
         */
        if ($treeNodeModify) {
            $node = new $modelClass;
            $successMsg = Yii::t('kvtree', 'The node was successfully created.');
            $errorMsg = Yii::t('kvtree', 'Error while creating the node. Please try again later.');
        } else {
            $tag = explode("\\", $modelClass);
            $tag = array_pop($tag);
            $id = $post[$tag][$keyAttr];
            $node = $modelClass::findOne($id);
            $successMsg = Yii::t('kvtree', 'Saved the node details successfully.');
            $errorMsg = Yii::t('kvtree', 'Error while saving the node. Please try again later.');
        }
        $node->activeOrig = $node->active;
        $isNewRecord = $node->isNewRecord;

        $tag = explode("\\", $modelClass);
        $tag = array_pop($tag);
        $id = $post[$tag][$keyAttr];

        $imgmodel = new ProductsOptions();
        $imgmodel->imagef = UploadedFile::getInstance($imgmodel, 'imagef');

        if($imgmodel->imagef != null){

            if ($imgmodel->upload()) {
             $path=$imgmodel->imagef->baseName . '.' . $imgmodel->imagef->extension;
                $node->image=$path;
            }

        }

        if(isset($data[$tag]["relPrices"])){

            $pid = (int)Yii::$app->request->get('pid');

            foreach ($data[$tag]["relPrices"] as $key => $value) {

               $modelprices=ProductsOptionsPrices::findOne(['product_options_id' => $id,'product_id' => $pid, 'price_id' => $key]);

               if($modelprices != null){

                 $modelprices->value=$value;

             }else{
                 $modelprices=new ProductsOptionsPrices();
                 $modelprices->product_options_id=$id;
                 $modelprices->price_id=$key;
                 $modelprices->product_id=$pid;
                 $modelprices->value=$value; 
             }

             $modelprices->save(); 
         }

     }
     $node->load($post);
     if ($treeNodeModify) {
        if ($parentKey == TreeView::ROOT_KEY) {
            $node->makeRoot();
        } else {
            $parent = $modelClass::findOne($parentKey);
            $node->appendTo($parent);
        }
    }
        $errors = $success = false;
        if ($node->save()) {

            // check if active status was changed
            if (!$isNewRecord && $node->activeOrig != $node->active) {
                if ($node->active) {
                    $success = $node->activateNode(false);
                    $errors = $node->nodeActivationErrors;
                } else {
                    $success = $node->removeNode(true, false); // only deactivate the node(s)
                    $errors = $node->nodeRemovalErrors;
                }
            } else {
                $success = true;
            }
            if (!empty($errors)) {
                $success = false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" . Yii::t('kvtree', "Node # {id} - '{name}': {error}", $err) . "</li>\n";
                }
                $errorMsg .= "</ul>";
            }
        } else {
            $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $node->getFirstErrors()) . '</li></ul>';
        }
        if (Yii::$app->has('session')) {
            $session = Yii::$app->session;
            $session->set(ArrayHelper::getValue($post, 'nodeSelected', 'kvNodeId'), $node->{$keyAttr});
            if ($success) {
                $session->setFlash('success', $successMsg);
            } else {
                $session->setFlash('error', $errorMsg);
            }
        } elseif (!$success) {
            throw new ErrorException("Error saving node!\n{$errorMsg}");
        }
        return $this->redirect($currUrl);
    }

    /**
     * Checks if request is valid and throws exception if invalid condition is true
     *
     * @param boolean $isJsonResponse whether the action response is of JSON format
     * @param boolean $isInvalid whether the request is invalid
     *
     * @throws InvalidCallException
     */
    protected static function checkValidRequest($isJsonResponse = true, $isInvalid = null)
    {
        $app = Yii::$app;
        if ($isJsonResponse) {
            $app->response->format = Response::FORMAT_JSON;
        }
        if ($isInvalid === null) {
            $isInvalid = !$app->request->isAjax || !$app->request->isPost;
        }
        if ($isInvalid) {
            throw new InvalidCallException(Yii::t('kvtree', 'This operation is not allowed.'));
        }
    }

    /**
     * Gets the data from $_POST after parsing boolean values
     *
     * @return array
     */
    protected static function getPostData()
    {
        if (empty($_POST)) {
            return [];
        }
        $out = [];
        foreach ($_POST as $key => $value) {
            $out[$key] = in_array($key, static::$boolKeys) ? filter_var($value, FILTER_VALIDATE_BOOLEAN) : $value;
        }
        return $out;
    }    
    /**
     * Deletes an existing ProductsOptions model.
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
     * Finds the ProductsOptions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsOptions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsOptions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
