<?php

namespace webdoka\yiiecommerce\backend;

use yii\base\BootstrapInterface;
use Yii;

class Module extends \yii\base\Module implements BootstrapInterface
{

    public function init()
    {
        parent::init();
        $this->setAliases(['@webdoka' => realpath($this->basePath . '/../')]);
        $this->defaultRoute = 'category/index';
    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $app->controllerMap['shop-rbac'] = [
                'class' => 'webdoka\yiiecommerce\backend\commands\ShopRbacController',
                'module' => $this,
            ];
        }
    }

}
