<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\OrderProperty;

/**
 * This is the ActiveQuery class for [[OrderProperty]].
 *
 * @see OrderProperty
 */
class OrderPropertyQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return OrderProperty[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrderProperty|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
