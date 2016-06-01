<?php

namespace shockedbear\shop;

use \yii\base\Module;

class ShopModule extends Module
{
    public function init()
    {
        parent::init();
        \Yii::configure($this, require __DIR__ . '/config.php');
    }
}