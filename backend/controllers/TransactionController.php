<?php

namespace webdoka\yiiecommerce\backend\controllers;

use webdoka\yiiecommerce\common\forms\TransactionForm;
use Yii;
use webdoka\yiiecommerce\common\models\Transaction;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
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
                        'roles' => [Transaction::LIST_TRANSACTION]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [Transaction::VIEW_TRANSACTION]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [Transaction::CREATE_TRANSACTION]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Transaction::DELETE_TRANSACTION]
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
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Transaction::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
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
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TransactionForm();

        $model->type = Yii::$app->request->get('type');
        $model->profile = Yii::$app->request->get('profile');
        $model->order = Yii::$app->request->get('order');
        $model->amount = Yii::$app->request->get('amount');
        $model->account_id = Yii::$app->request->get('account_id');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->type == Transaction::CHARGE_TYPE) {
                Yii::$app->billing->charge($model->account_id, $model->amount, $model->description);
            } elseif ($model->type == Transaction::WITHDRAW_TYPE) {
                Yii::$app->billing->withdraw($model->account_id, $model->amount, $model->description, $model->order);
            } elseif ($model->type == Transaction::ROLLBACK_TYPE) {
                Yii::$app->billing->rollback($model->transaction, $model->description);
            } else {
                throw new InvalidParamException(Yii::t('shop', 'Invalid transaction type.'));
            }
            return $this->redirect(['index']);
        } else {
            $url = Url::to(['create']);
            return $this->render('create', compact('model', 'url'));
        }
    }

    /**
     * Deletes an existing Transaction model.
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
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }

}
