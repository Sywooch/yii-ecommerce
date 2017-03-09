<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\OrderSet;

/**
 * This is the ActiveQuery class for [[OrderSet]].
 *
 * @see OrderSet
 */
class OrderSetQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return OrderSet[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrderSet|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
