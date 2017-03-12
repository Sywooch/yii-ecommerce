<?php

namespace webdoka\yiiecommerce\frontend\controllers;

use Yii;
use webdoka\yiiecommerce\common\models\Product;
use yii\data\ArrayDataProvider;

/**
 * Class CartController
 * @package webdoka\yiiecommerce\frontend\controllers
 */
class CartController extends \yii\web\Controller
{

    /**
     * @return string
     */
    public function actionList()
    {
        $sets = Yii::$app->cart->getSets();
        $positions = Yii::$app->cart->getPositions();
        $setsDataProvider = new ArrayDataProvider(['allModels' => $sets]);
        $positionsDataProvider = new ArrayDataProvider(['allModels' => $positions]);

        return $this->render('list', compact('setsDataProvider', 'positionsDataProvider'));
    }

    /**
     * @param $id
     */
    public function actionAdd($id)
    {
        $optid = Yii::$app->request->get('option');

        if(!isset($optid) || $optid==''){
           $optid=0; 
        }

        $qty = (int)Yii::$app->request->get('qty', 1);

        if ($product = Product::findOne($id)) {


            $product->setQuantity($qty);
            $product->setOptid($optid);


            Yii::$app->cart->put($product);
        }
        $this->redirect(['catalog/index']);
    }

    /**
     * @param $id
     */
    public function actionUpdate($id, $change, $quant, $minus=-1)
    {



        foreach ($_GET as $key => $value) {

            if (stripos($key, 'option') !== false)

                $option[] = (int)urldecode($value);
            

        }

        $product = Product::findOne($id);
        if ($product != null && !empty($option)) {

            $newid=implode(',', $option);

//var_dump($newid);exit;

            $branch = $product->getBranchOption((int)$newid);
            $parent = $branch['option']->parents(1)->one();

            $newchanges = [];


        if($change > 0 && $change != ''){

            foreach (explode(',',$change) as $data) {

            $branchchanges = $product->getBranchOption((int)$data);
            $parentchanges = $branchchanges['option']->parents(1)->one();

           if($parentchanges->id == $parent->id){

            $newchanges[]=(int)$newid;

           }else{

            $newchanges[]=(int)$data;

           } 


            }

        }else{

            $change = 0;
            $newchanges[]=$newid;
       
            
        }


        if(!in_array($newid,$newchanges)){

            $newchanges = array_merge($option,$newchanges);
        }

            asort($newchanges);

            $product->setOptid(implode(',', $newchanges));

            Yii::$app->cart->updateopt($product, implode(',', $newchanges), $change, $quant);

        }elseif($product = Product::findOne($id)){


           if($minus > 0){

                $newchanges = explode(',', $change);
               unset($newchanges[array_search($minus,$newchanges)]);

            }

            asort($newchanges);


           // var_dump($newchanges);exit;

            $product->setOptid(implode(',', $newchanges));

            Yii::$app->cart->updateopt($product, implode(',', $newchanges), $change, $quant);
        }
        $this->redirect(['cart/list']);
    }

    /**
     * @param $id
     */
    public function actionRemove($id, $option)
    {

        if ($product = Product::findOne($id)) {
            Yii::$app->cart->remove($product, $option);
            $this->redirect(['cart/list']);
        }
    }

    /**
     * Removes set by tmpId
     */
    public function actionRemoveSet()
    {
        Yii::$app->cart->removeSetById(Yii::$app->request->get('id'));
        $this->redirect(['cart/list']);
    }

}
