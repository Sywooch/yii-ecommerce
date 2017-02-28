<?php

namespace webdoka\yiiecommerce\common\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use webdoka\yiiecommerce\common\models\TranslateDynamicText;
use webdoka\yiiecommerce\common\models\Lang;
use yii\helpers\ArrayHelper;

class Translate extends Behavior
{
	
	public $in_name = false;

	public $in_description = false;

	public $in_shortdescription = false;

	public $modelID = false;

	public $_curentlang = 'en';	



	public function events()
	{
		$action = Yii::$app->controller->action->id;
		
		if ($action == 'update' || $action == 'create') {

			return [
			ActiveRecord::EVENT_BEFORE_UPDATE => 'saveTranslate',
			ActiveRecord::EVENT_AFTER_INSERT => 'saveTranslate',
			];

		}else{

			return [
			ActiveRecord::EVENT_AFTER_FIND => 'getTranslate',
			];

		}

	}


	public function getTranslate( $event )
	{

		if( $this->getTranslateCurentlang() !=null ){

			if ( $this->in_name != false ){

				if ( empty( $this->owner->{$this->in_name} ) ) {

					$this->owner->{$this->in_name} = $this->getTranslateCurentlang()->name;

				} else {

					$this->owner->{$this->in_name} = $this->getTranslateCurentlang()->name;
				}
			}

			if ( $this->in_description != false ){

				if ( empty( $this->owner->{$this->in_description} ) ) {

					$this->owner->{$this->in_description} = $this->getTranslateCurentlang()->description;

				} else {

					$this->owner->{$this->in_description} = $this->getTranslateCurentlang()->description;
				}
			}

			if ( $this->in_shortdescription != false ){

				if ( empty( $this->owner->{$this->in_shortdescription} ) ) {

					$this->owner->{$this->in_shortdescription} = $this->getTranslateCurentlang()->short_description;

				} else {

					$this->owner->{$this->in_shortdescription} = $this->getTranslateCurentlang()->short_description;
				}
			}

		}

	}



	public function saveTranslate( $event )
	{
		
		$post=Yii::$app->request->post();
		
		$model_id=explode('\\',$this->modelID);
		
		$modelid=end($model_id);


		$langs=Lang::find()->all();

		foreach ($langs as $key => $lang){

			if(ArrayHelper::keyExists($lang->url, $post[$modelid], false)){

				if(isset($post[$modelid][$lang->url][$this->in_name])){
					$name = $post[$modelid][$lang->url][$this->in_name];
				}else{
					$name = NULL;
				}

				if(isset($post[$modelid][$lang->url][$this->in_description])){
					$description = $post[$modelid][$lang->url][$this->in_description];
				}else{
					$description= NULL;
				}

				if(isset($post[$modelid][$lang->url][$this->in_shortdescription])){
					$short_description = $post[$modelid][$lang->url][$this->in_shortdescription];
				}else{
					$short_description = NULL;
				}

					$translate = $this->getTranslateFromlang($lang->url);

					if($translate != null){

						$translate->lang = $lang->url;
						$translate->modelID = $this->modelID;
						$translate->itemID = $this->owner->id;
						$translate->name = $name;
						$translate->description = $description;
						$translate->short_description = $short_description;

					}else{

						$translate = new TranslateDynamicText();
						$translate->lang = $lang->url;
						$translate->modelID = $this->modelID;
						$translate->itemID = $this->owner->id;
						$translate->name = $name;
						$translate->description = $description;
						$translate->short_description = $short_description;

					}

					$translate->save();


				
			}


		}

	}

        public function getCurentlang()
        {
        	return Lang::getCurrent()->url;

        }	


        private function getTranslateCurentlang()
        {
        	return TranslateDynamicText::find()->where(['itemID'=>$this->owner->id])->andWhere(['modelID'=>$this->modelID])->andWhere(['lang'=>$this->CurentLang])->one();

        }

        private function getTranslateFromlang($lang)
        {
        	return TranslateDynamicText::find()->where(['itemID'=>$this->owner->id])->andWhere(['modelID'=>$this->modelID])->andWhere(['lang'=>$lang])->one();

        }       


    }