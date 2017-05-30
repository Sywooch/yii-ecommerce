<?php

namespace webdoka\yiiecommerce\frontend\widgets;

/**
 * Class ProductsOptions
 * @package webdoka\yiiecommerce\frontend\widgets
 */
class ProductsOptions extends \yii\base\Widget
{

    public $model;
    public $rootid;
    public $child;
    public $url = '/shop/product/index/';
    public $oldoption = [];

    public function run()
    {
        return $this->render('productoptions', [
            'model' => $this->model,
            'url' => $this->url,
            'rootid' => $this->rootid,
            'child' => $this->child,
            'oldoption' => $this->oldoption
        ]);
    }

}
