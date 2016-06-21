<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Delivery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class DeliveryForm
 * @package webdoka\yiiecommerce\common\forms
 */
class DeliveryForm extends Delivery
{
    public
        $country,
        $city;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['country', 'city'], 'string', 'max' => 255],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country' => 'Country',
            'city' => 'City',
        ];
    }
}
