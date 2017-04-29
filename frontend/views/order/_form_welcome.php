<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use webdoka\yiiecommerce\common\models\Profiles;
use webdoka\yiiecommerce\common\models\Country;

/* @var $this yii\web\View */
/* @var $model webdoka\yiiecommerce\common\models\Profiles */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Sign Up');
$this->params['breadcrumbs'][] = $this->title;

$js = <<< 'SCRIPT'
$("document").ready(function(){ 
        $("#pjax-container").on("pjax:end", function() {
            //$.pjax.reload({container:"#countries"});  //Reload GridView
        });
    });
SCRIPT;
$this->registerJs($js);
$cid = 0;
$qr = '';
$qc = '';
if (isset($modcust)) {
    $cid = Country::getCountryId($modcust->country);

    if ($cid) {
        if ($modcust->region != null) {
            $qr = $modcust->region;
        }else{

        } 

        if ($modcust->city != null) {
            $qc = $modcust->city;
        } 

}
}
$js = '
$("document").ready(function(){ 

        $("#fromer").on("change", function() {

            if($("#fromer").val() != ""){
                $.pjax.reload({
                    container:"#profiles",
                    url: "/shop/order/welcome/?prf="+$("#fromer").val(),push: false
            });

            $(document).on("pjax:complete", function() {

if($("#fromer").val() != ""){

            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formregion') . '",{cid:$("#profiles-country-'.Profiles::STATUS_CUSTOMER.'").val(), type:'.Profiles::STATUS_CUSTOMER.', q:$("#profiles-region-'.Profiles::STATUS_CUSTOMER.'").val()},
                            function( data ) {    
                            $( "#regioncontainer_'.Profiles::STATUS_CUSTOMER.'" ).html(data);
                            });
            
            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formcity') . '",{cid:$("#profiles-country-'.Profiles::STATUS_CUSTOMER.'").val(),region:"'.$qr.'", type:'.Profiles::STATUS_CUSTOMER.', q:$("#profiles-city-'.Profiles::STATUS_CUSTOMER.'").val()},

                            function( data ) {
                                $( "#citycontainer_'.Profiles::STATUS_CUSTOMER.'" ).html(data);
                            });

            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formregion') . '",{cid:$("#profiles-country-'.Profiles::STATUS_CUSTOMER.'").val(), type:'.Profiles::STATUS_RECIPIENT.', q:$("#profiles-region-'.Profiles::STATUS_RECIPIENT.'").val()},
                            function( data ) {    
                            $( "#regioncontainer_'.Profiles::STATUS_RECIPIENT.'" ).html(data);
                            });
            
            $.post( "' . Yii::$app->urlManager->createUrl('shop/order/formcity') . '",{cid:$("#profiles-country-'.Profiles::STATUS_CUSTOMER.'").val(),region:"'.$qr.'", type:'.Profiles::STATUS_RECIPIENT.', q:$("#profiles-city-'.Profiles::STATUS_RECIPIENT.'").val()},

                            function( data ) {
                                $( "#citycontainer_'.Profiles::STATUS_RECIPIENT.'" ).html(data);
                            });
}

});

            }else{
                $.pjax.reload({
                    container:"#profiles",
                    url: "/shop/order/welcome",push: false
            });
          
                $( "#regioncontainer_'.Profiles::STATUS_CUSTOMER.'" ).html(""); 
                $( "#citycontainer_'.Profiles::STATUS_CUSTOMER.'" ).html(""); 
                $( "#regioncontainer_'.Profiles::STATUS_RECIPIENT.'" ).html(""); 
                $( "#citycontainer_'.Profiles::STATUS_RECIPIENT.'" ).html(""); 
          

                        }

        });
    });
';
$this->registerJs($js);


$myprofiles = Profiles::find()->where(['user_id' => isset(Yii::$app->user->identity->id) ? (Yii::$app->user->identity->id) : (''), 'status' => Profiles::STATUS_CUSTOMER])->all();

?>

<?php Pjax::begin([
    'id' => 'pjax-container',
    'enablePushState' => false,
]); ?>

    <div class="row" id="countries">
        <div class="col-xs-12">
            
                <div class="col-xs-12 col-sm-4" style="padding-bottom: 30px;">
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <?= $this->render('_signform', compact('modelsignup', 'modellogin')); ?>
                     <?php else: ?> 
            <div class="single-sidebar">
            <div class="sidebar-title"><h4><?= Yii::t('shop', 'Welcome') ?> <?=Yii::$app->user->identity->username ?></h4></div>
            <div class="price-slider-wrap">
Balance
            </div>


        </div>
            <div class="single-sidebar">
            <div class="sidebar-title"><h4><?= Yii::t('shop', 'Select Profiles') ?></h4></div>
        
            <?= Html::dropDownList('from', Yii::$app->request->get('prf',0),
                ArrayHelper::map($myprofiles, 'id', 'profile_name'),
                [
                    
                    'id' => 'fromer',
                    'class' => 'form-control',
                    'prompt'=>Yii::t('shop', 'Select')
                ]
            ) ?>           



        </div>

                    <?php endif; ?>

                </div>
                <div class="col-xs-12 col-sm-8">
                    <?= $this->render('_profiles', compact('model', 'modcust', 'modelrec', 'status', 'modelre')); ?>


                </div>
            
        </div>
    </div>
<?php Pjax::end(); ?>