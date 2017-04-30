<?php
use yii\helpers\Url;
?>

<img src="<?=$model->fullName?>" alt="" class>
<a href="<?=Url::to(['/admin/shop/products-options/image-delete', 'id'=>$model->id])?>" onclick="return confirm('Вы уверены?')">X</a>
