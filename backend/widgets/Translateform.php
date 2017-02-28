<?php

namespace webdoka\yiiecommerce\backend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Widget;
use yii\helpers\Html;


class Translateform extends Widget
{

public $form;
public $model;
public $attr;
public $field='name';
public $formtype='string';

    /**
     * Renders the widget.
     */
    public function run()
    {
        return $this->render('translateform',[
            'form'  => $this->form,
            'model' => $this->model,
            'attr'  => $this->attr,
            'field'  => $this->field,
            'formtype'  => $this->formtype,
            ]);
    }

}
