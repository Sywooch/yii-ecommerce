<?php

namespace webdoka\yiiecommerce\backend;

use yii\base\BootstrapInterface;
use Yii;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
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