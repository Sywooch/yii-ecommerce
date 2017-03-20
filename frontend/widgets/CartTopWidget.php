<?php

namespace webdoka\yiiecommerce\frontend\widgets;

/**
 * Class CartWidget
 * @package webdoka\yiiecommerce\frontend\widgets
 */
class CartTopWidget extends \yii\base\Widget
{

    public function run()
    {
        return $this->render('carttop');
    }

}
