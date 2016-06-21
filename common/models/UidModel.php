<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * Class UidModel
 * @package webdoka\yiiecommerce\common\models
 */
abstract class UidModel extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->uid = md5(microtime());
        }

        return parent::beforeSave($insert);
    }
}
