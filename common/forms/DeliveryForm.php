<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Delivery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class DeliveryForm
 * @package webdoka\yiiecommerce\common\forms
 */
class DeliveryForm extends Delivery {

    public
            $country,
            $city;

    /**
     * @inheritdoc
     */
    public function rules() {
        return ArrayHelper::merge([
                    [['country', 'city'], 'string', 'max' => 255],
                        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'country' => Yii::t('shop', 'Country'),
            'city' => Yii::t('shop', 'City'),
            'street' => Yii::t('shop', 'Street'),
            'name' => Yii::t('shop', 'Name'),
            'cost' => Yii::t('shop', 'Cost'),
            'storage_id' => Yii::t('shop', 'Storage'),
        ];
    }

}
