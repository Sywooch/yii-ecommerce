<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\CartSet;

/**
 * This is the ActiveQuery class for [[CartSet]].
 *
 * @see CartSet
 */
class CartSetQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return CartSet[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CartSet|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
