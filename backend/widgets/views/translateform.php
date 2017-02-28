<?php 
use webdoka\yiiecommerce\common\models\Lang;
use webdoka\yiiecommerce\common\models\TranslateDynamicText;      
?>

<div class="box box-widget collapsed-box">


  <div class="box-tools pull-right">
    <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-plus"></i> <?=Yii::t('shop', 'Translate')?>
    </button>
</div>
<!-- /.box-tools -->

<!-- /.box-header -->
<div class="box-body" style="display: none;">

    <?php $langs=Lang::find()->all();?>

    <?php foreach ($langs as $key => $lang): ?>

        <?php 

        $translate = TranslateDynamicText::find()->where(['itemID'=>$model->id])->andWhere(['modelID'=>get_class($model)])->andWhere(['lang'=>$lang->url])->one();

        $value='';

        if($translate != null){

            if($field == 'name'){

                if($translate->name){
                    $value = $translate->name;
                }else{
                    $value = '';
                }

                echo $form->field($model, "[$lang->url]".$attr)->textInput(['value'=>$value])->label(Yii::t('shop', ucfirst($attr)).' '.$lang->name);

            }

            if($field == 'description'){

                if($translate->description){
                    $value = $translate->description;
                }else{
                    $value = '';
                }

                if($formtype == 'string'){
                  echo $form->field($model, "[$lang->url]".$attr)->textInput(['value'=>$value])->label(Yii::t('shop', ucfirst($attr)).' '.$lang->name);
              }

              if($formtype == 'text'){
                  echo $form->field($model, "[$lang->url]".$attr)->textarea(['rows' => '6','value'=>$value])->label(Yii::t('shop', ucfirst($attr)).' '.$lang->name);
              }
          }

          if($field == 'short_description'){

            if($translate->short_description){
                $value = $translate->short_description;
            }else{
                $value = '';
            }

            if($formtype == 'string'){

              echo $form->field($model, "[$lang->url]".$attr)->textInput(['value'=>$value])->label(Yii::t('shop', ucfirst($attr)).' '.$lang->name);

          }

          if($formtype == 'text'){

              echo $form->field($model, "[$lang->url]".$attr)->textarea(['rows' => '6','value'=>$value])->label(Yii::t('shop', ucfirst($attr)).' '.$lang->name);
          }

      }



  }else{

      echo $form->field($model, "[$lang->url]".$attr)->textInput(['value'=>''])->label(Yii::t('shop', ucfirst($attr)).' '.$lang->name);
  }

  ?>
<?php endforeach ?>
</div>
<!-- /.box-body -->
</div>