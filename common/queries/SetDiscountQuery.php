<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\SetDiscount;

/**
 * This is the ActiveQuery class for [[SetDiscount]].
 *
 * @see SetDiscount
 */
class SetDiscountQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return SetDiscount[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SetDiscount|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
