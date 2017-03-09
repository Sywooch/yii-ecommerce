<?php

namespace webdoka\yiiecommerce\frontend\widgets;

/**
 * Class ProductsOptions
 * @package webdoka\yiiecommerce\frontend\widgets
 */
class ProductsOptions extends \yii\base\Widget
{

    public $model;
    public $url = '/shop/product/index/';
    public $oldoption = 0;

    public function run()
    {
        return $this->render('productoptions', ['model' => $this->model, 'url' => $this->url, 'oldoption' => $this->oldoption]);
    }

}
