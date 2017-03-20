<?php

namespace webdoka\yiiecommerce\frontend;

class Module extends \yii\base\Module
{

    public function init()
    {
        parent::init();
        $this->setAliases(['@webdoka' => realpath($this->basePath . '/../')]);
        $this->defaultRoute = 'catalog/index';
    }

}
