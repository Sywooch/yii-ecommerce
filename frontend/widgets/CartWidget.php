<?php

namespace webdoka\yiiecommerce\frontend\widgets;

/**
 * Class CartWidget
 * @package webdoka\yiiecommerce\frontend\widgets
 */
class CartWidget extends \yii\base\Widget
{

    public function run()
    {
        return $this->render('cart');
    }

}
