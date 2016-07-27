<?php

namespace webdoka\yiiecommerce\frontend\components;

use yii\base\Widget;

class CountryWidget extends Widget
{
    public $cssClass;

    public function init()
    {
        parent::init();
        if ($this->cssClass === null) {
            $this->cssClass = 'form-control';
        }
    }

    public function run()
    {
        return $this->render('country', ['cssClass' => $this->cssClass]);
    }
}