<?php

namespace webdoka\yiiecommerce;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function init()
    {
        parent::init();
        \Yii::configure($this, require __DIR__ . '/config.php');
    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $app->controllerMap['rbac'] = [
                'class' => 'webdoka\yiiecommerce\commands\RbacController',
                'module' => $this,
            ];
        }
    }
}